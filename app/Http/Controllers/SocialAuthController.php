<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    // Redirects
    public function redirect(string $provider)
    {
        // Ensure provider is configured to avoid provider errors like missing client_id
        $config = config("services.$provider");
        if (!$config || empty($config['client_id']) || empty($config['client_secret']) || empty($config['redirect'])) {
            return redirect()->route('login')->withErrors([
                'social' => ucfirst($provider).' login is not configured. Please set '.$provider.' credentials in .env.'
            ]);
        }
        return Socialite::driver($provider)->redirect();
    }

    // Callback handler
    public function callback(string $provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['social' => 'Could not authenticate with '.ucfirst($provider).'.']);
        }

        $email = $socialUser->getEmail();
        $name  = $socialUser->getName() ?: ($socialUser->getNickname() ?: 'User');

        // Some providers (Apple) may not always return email after first consent.
        if (!$email) {
            return redirect()->route('login')->withErrors(['social' => 'Your '.ucfirst($provider).' account did not provide an email address.']);
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make(Str::random(32)),
                'email_verified_at' => now(),
            ]
        );

        Auth::login($user, true);
        return redirect()->route('profile');
    }
}
