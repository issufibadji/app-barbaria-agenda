<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class TwoFactorAuthController extends Controller
{
   public function show()
{
    $user = Auth::user();
    $google2fa = new Google2FA();

    // Se já confirmado, não mostra QR Code novamente
    if ($user->confirmed_2fa) {
        return redirect()->route('profile.edit')
            ->with('status', 'A autenticação em dois fatores já está ativada.');
    }

    try {
        $secret = $user->google2fa_secret
            ? Crypt::decrypt($user->google2fa_secret)
            : null;
    } catch (\Exception $e) {
        \Log::error('Erro ao descriptografar chave 2FA: ' . $e->getMessage());
        $secret = null;
    }

    if (!$secret) {
        $secret = $google2fa->generateSecretKey();
        $user->google2fa_secret = Crypt::encrypt($secret);
        $user->save();
    }

    $qrCodeUrl = $google2fa->getQRCodeUrl(
        config('app.name'),
        $user->email,
        $secret
    );

    $renderer = new ImageRenderer(
        new RendererStyle(200),
        new SvgImageBackEnd()
    );

    $writer = new Writer($renderer);
    $qrCodeSvg = $writer->writeString($qrCodeUrl);

    return inertia('Profile/TwoFactorSetup', [
        'qrCodeUrl' => 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg),
        'secretKey' => $secret,
        'user' => $user,
    ]);
}



public function enable(Request $request)
{
    $user = $request->user();
    $code = $request->input('code');
    $secret = $request->input('secret'); // ou use da session

    $google2fa = new \PragmaRX\Google2FA\Google2FA();

    // ✅ validação com tolerância de tempo
    $isValid = $google2fa->verifyKeyNewer($secret, $code, 2); // 1 = aceita 30s antes ou depois

    \Log::info('Tentativa de ativar 2FA', [
        'user_id' => $user->id,
        'codigo' => $code,
        'chave' => $secret,
        'valido' => $isValid ? 'true' : 'false'
    ]);


    if (! $isValid) {
        return back()->withErrors(['code' => 'Código inválido. Tente novamente.']);
    }

    $user->google2fa_secret = Crypt::encrypt($secret);
    $user->save();

    return back()->with('status', 'Autenticação de 2 fatores ativada com sucesso!');
}



public function disable()
{
    try {
        $user = Auth::user();
        $user->google2fa_secret = null;
        $user->confirmed_2fa = false;
        $user->save();

        return back()->with('success', '2FA desativado com sucesso.');
    } catch (\Throwable $e) {
        \Log::error('Erro ao desativar 2FA', [
            'user_id' => Auth::id(),
            'erro' => $e->getMessage()
        ]);

        return back()->with('error', 'Erro ao desativar 2FA. Tente novamente.');
    }
}

}
