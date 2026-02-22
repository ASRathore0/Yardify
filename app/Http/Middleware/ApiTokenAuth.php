<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\ApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiTokenAuth
{
    public function handle(Request $request, Closure $next)
    {
        $bearer = $request->bearerToken();
        if (!$bearer) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $hash = hash('sha256', $bearer);
        $token = ApiToken::where('token_hash', $hash)->first();
        if (!$token) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        Auth::loginUsingId($token->user_id);
        $token->last_used_at = now();
        $token->save();
        $request->attributes->set('api_token', $token);

        return $next($request);
    }
}
