<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocationController extends Controller
{
    public function saveLocation(Request $request)
    {
        $validated = $request->validate([
            'location' => 'required|string|max:255',
        ]);

        // Save in session for both guests and authenticated users
        session(['user_location' => $validated['location']]);

        // Save in database if authenticated
        if (auth()->check()) {
            $user = auth()->user();
            DB::table('users')->where('id', $user->id)->update([
                'city' => $validated['location']
            ]);
        }

        return response()->json(['success' => true]);
    }
}
