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
        
        $driver = Socialite::driver($provider);
        
        if ($provider === 'google') {
           $driver->scopes([
               'https://www.googleapis.com/auth/userinfo.profile', 
               'https://www.googleapis.com/auth/userinfo.email',
               'https://www.googleapis.com/auth/user.phonenumbers.read',
               'https://www.googleapis.com/auth/user.birthday.read'
           ]);
        }

        return $driver->redirect();
    }

    // Callback handler
    public function callback(string $provider)
    {
        try {
            $driver = Socialite::driver($provider);
            
            if ($provider === 'google') {
                $socialUser = $driver->stateless()->user();
            } else {
                $socialUser = $driver->user();
            }
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['social' => 'Could not authenticate with '.ucfirst($provider).'. ERROR: '.$e->getMessage()]);
        }
        
        $email = $socialUser->getEmail();
        $name  = $socialUser->getName() ?: ($socialUser->getNickname() ?: 'User');
        $avatar = $socialUser->getAvatar();

        // Attempt to extract phone/DOB if provided by the social provider's raw payload (Requires specially approved scopes for Google/Facebook)
        $rawUser = $socialUser->getRaw();
        $phone = $rawUser['phone'] ?? $rawUser['phoneNumber'] ?? $rawUser['phone_number'] ?? null;
        $dob = $rawUser['birthday'] ?? $rawUser['date_of_birth'] ?? null;

        // Some providers (Apple) may not always return email after first consent.
        if (!$email) {
            return redirect()->route('login')->withErrors(['social' => 'Your '.ucfirst($provider).' account did not provide an email address.']);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'email' => $email,
                'name' => $name,
                'password' => Hash::make(Str::random(32)),
                'email_verified_at' => now(),
                'avatar_path' => $avatar,
                'phone' => $phone,
                'date_of_birth' => $dob ? date('Y-m-d', strtotime($dob)) : null,
            ]);
        } else {
            // Update any missing profile details to match their social account
            $updates = [];
            if (empty($user->avatar_path) && $avatar) {
                $updates['avatar_path'] = $avatar;
            }
            if (empty($user->phone) && $phone) {
                $updates['phone'] = $phone;
            }
            if (empty($user->date_of_birth) && $dob) {
                $updates['date_of_birth'] = date('Y-m-d', strtotime($dob));
            }

            if (!empty($updates)) {
                $user->update($updates);
            }
        }

        Auth::login($user, true);
        return redirect()->route('profile');
    }
}
