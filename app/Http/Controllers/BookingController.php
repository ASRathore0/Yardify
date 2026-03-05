<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Vendor;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'service_name' => 'required|string',
            'scheduled_at' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        if (!auth()->check()) {
            if ($request->ajax() || $request->wantsJson()) return response()->json(['error' => 'Please login to book a service.'], 401);
            return redirect()->route('login')->with('error', 'Please login to book a service.');
        }

        $vendor = Vendor::findOrFail($request->vendor_id);

        Booking::create([
            'vendor_id' => $vendor->id,
            'user_id' => auth()->id(),
            'service_name' => $request->service_name,
            'price' => $request->price ?? $vendor->base_price ?? 0,
            'status' => 'pending',
            'scheduled_at' => $request->scheduled_at,
            'notes' => $request->notes,
        ]);

        if ($request->ajax() || $request->wantsJson()) return response()->json(['success' => 'Booking created successfully!']);
        return redirect()->back()->with('success', 'Booking created successfully! Waiting for vendor approval.');
    }

    public function userBookings()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        $bookings = Booking::where('user_id', auth()->id())->with('vendor')->latest()->get();
        return view('user.bookings', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        // Add auth check + relation existence check to be safe
        if (!auth()->check() || !$booking->vendor || $booking->vendor->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $booking->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Booking status updated.');
    }
}
