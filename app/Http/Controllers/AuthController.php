<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('profile');
        }
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        $redirect = $request->input('redirect');
        $final = route('profile');
        if ($redirect) {
            $parts = parse_url($redirect);
            // allow relative paths or same-host absolute URLs only
            if ((!isset($parts['host']) && isset($parts['path'])) || (isset($parts['host']) && $parts['host'] === $request->getHost())) {
                $final = $redirect;
            }
        }
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 'success', 'redirect' => $final]);
        }
        return redirect()->to($final);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, true)) {
            $request->session()->regenerate();
            $redirect = $request->input('redirect');
            $final = route('profile');
            if ($redirect) {
                $parts = parse_url($redirect);
                if ((!isset($parts['host']) && isset($parts['path'])) || (isset($parts['host']) && $parts['host'] === $request->getHost())) {
                    $final = $redirect;
                }
            }
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['status' => 'success', 'redirect' => $final]);
            }
            return redirect()->to($final);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['status' => 'error', 'message' => 'Invalid credentials'], 422);
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
