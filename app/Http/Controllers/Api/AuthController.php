<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ApiToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected function createTokenFor(User $user, string $name = 'mobile'): string
    {
        $plain = bin2hex(random_bytes(40));
        $hash = hash('sha256', $plain);
        ApiToken::create([
            'user_id' => $user->id,
            'token_hash' => $hash,
            'name' => $name,
        ]);
        return $plain;
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = $this->createTokenFor($user);

        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages(['email' => ['The provided credentials are incorrect.']]);
        }

        $token = $this->createTokenFor($user);
        return response()->json(['token' => $token, 'user' => $user]);
    }

    public function logout(Request $request)
    {
        $token = $request->attributes->get('api_token');
        if ($token) {
            $token->delete();
        }
        return response()->json(['message' => 'Logged out']);
    }

    public function me(Request $request)
    {
        return response()->json($request->user());
    }
}
