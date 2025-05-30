<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Support\Facades\Crypt;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        $user = $request->user();
        $google2fa = new Google2FA();

        try {
            if (!$user->google2fa_secret) {
                throw new \Exception('No secret yet');
            }

            // Tenta descriptografar o segredo existente
            $secret = Crypt::decrypt($user->google2fa_secret);
        } catch (\Exception $e) {
            // Se não existir ou falhar, gera um novo
            $secret = $google2fa->generateSecretKey();
            $user->google2fa_secret = Crypt::encrypt($secret);
            $user->save();
        }

        // Gera QRCode
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

        return Inertia::render('Profile/Edit', [
            'auth' => ['user' => $user],
            'mustVerifyEmail' => $user instanceof MustVerifyEmail,
            'status' => session('status'),
            'qrCodeUrl' => 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg),
            'secretKey' => $secret,
        ]);
    }
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
