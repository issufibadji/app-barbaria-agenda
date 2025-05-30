<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use PragmaRX\Google2FA\Google2FA;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Illuminate\Contracts\Encryption\DecryptException;
use BaconQrCode\Writer;

class TwoFactorAuthController extends Controller
{
  public function show()
  {
    $user = Auth::user();
    $google2fa = new Google2FA();

    try {
        if (!$user->google2fa_secret) {
            $secretKey = $google2fa->generateSecretKey();
            $user->google2fa_secret = Crypt::encrypt($secretKey);
            $user->save();
        }

        $secret = Crypt::decrypt($user->google2fa_secret);
    } catch (DecryptException $e) {
        // Resetar secret se estiver inválido
        $secretKey = $google2fa->generateSecretKey();
        $user->google2fa_secret = Crypt::encrypt($secretKey);
        $user->save();
        $secret = $secretKey;
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
        $request->validate(['code' => 'required']);
        $user = Auth::user();
        $google2fa = new Google2FA();

        $isValid = $google2fa->verifyKey(
            Crypt::decrypt($user->google2fa_secret),
            $request->code
        );

        if ($isValid) {
            $user->active_2fa = true;
            $user->save();

            return back()->with('success', '2FA ativado com sucesso.');
        }

        return back()->with('error', 'Código inválido.');
    }

    public function disable()
    {
        $user = Auth::user();
        $user->active_2fa = false;
        $user->google2fa_secret = null;
        $user->save();

        return back()->with('success', '2FA desativado.');
    }
}
