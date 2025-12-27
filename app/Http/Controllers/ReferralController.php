<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if (empty($user->referral_code)) {
            // Generate a unique 8-char uppercase code
            do {
                $code = strtoupper(Str::random(8));
            } while ($user->newQuery()->where('referral_code', $code)->exists());

            $user->referral_code = $code;
            $user->save();
        }

        $referralCode = $user->referral_code;
        return view('refer_earn', compact('referralCode'));
    }
}
