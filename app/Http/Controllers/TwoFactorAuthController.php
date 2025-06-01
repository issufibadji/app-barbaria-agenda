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

        $secret = $google2fa->generateSecretKey();

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
        'secretKey' => $secret, // 🔑 chave ainda NÃO salva
        'user' => $user,
    ]);

    }

 public function enable(Request $request)
{
    try {
        $request->validate([
            'code' => 'required',
            'secret' => 'required',
        ]);

        $user = Auth::user();
        $google2fa = new \PragmaRX\Google2FA\Google2FA();

        $secret = $request->secret;

        $isValid = $google2fa->verifyKeyNewer($secret, $request->code, 1); // tolerância 30s

        \Log::info('Tentativa de ativar 2FA:', [
            'user_id' => $user->id,
            'codigo' => $request->code,
            'chave' => $secret,
            'valido' => $isValid,
        ]);

        if ($isValid !== false) {
            $user->google2fa_secret = Crypt::encrypt($secret);
            $user->active_2fa = true;
            $user->save();

            return back()->with('success', '2FA ativado com sucesso.');
        }

        return back()->with('error', 'Código inválido.');
    } catch (\Throwable $e) {
        \Log::error('Erro ao ativar 2FA', [
            'user_id' => Auth::id(),
            'error' => $e->getMessage(),
        ]);

        return back()->with('error', 'Ocorreu um erro ao ativar o 2FA. Tente novamente.');
    }
}




    public function disable()
    {
        try {
            $user = Auth::user();
            $user->active_2fa = false;
            $user->google2fa_secret = null;
            $user->save();

            return back()->with('success', '2FA desativado.');
        } catch (\Throwable $e) {
            \Log::error('Erro ao desativar 2FA', [
                'user_id' => Auth::id(),
                'erro' => $e->getMessage()
            ]);

            return back()->with('error', 'Erro ao desativar 2FA. Tente novamente.');
        }
    }
}
