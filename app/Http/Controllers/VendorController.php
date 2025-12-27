<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\VendorService;
use App\Models\Booking;
use App\Models\VendorTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorController extends Controller
{
    public function entry(Request $request)
    {
        $vendor = Vendor::where('user_id', $request->user()->id)->first();
        return $vendor
            ? redirect()->route('vendor.dashboard')
            : redirect()->route('vendor.form');
    }
    public function form()
    {
        return view('vendor_form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'service' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'pin_code' => 'nullable|string|max:10',
            'area' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'base_price' => 'nullable|integer|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'contact_number' => 'nullable|string|max:32',
            'whatsapp_number' => 'nullable|string|max:32',
            'email' => 'nullable|email',
            'image' => 'nullable|image|max:4096',
            'other_services' => 'array',
            'other_services.*' => 'string|max:120',
        ]);

        $vendor = new Vendor($data);
        $vendor->user_id = $request->user()->id;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('vendors', 'public');
            $vendor->image_path = $path;
        }

        $vendor->save();

        $services = $data['other_services'] ?? [];
        foreach ($services as $name) {
            if (!empty($name)) {
                VendorService::create(['vendor_id' => $vendor->id, 'name' => $name]);
            }
        }

        // After creating a vendor redirect to public dashboard and prefill search
        $params = [];
        if ($vendor->service) $params['service'] = $vendor->service;
        if ($vendor->city) $params['city'] = $vendor->city;
        if ($vendor->category) $params['category'] = $vendor->category;
        $url = route('home');
        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }
        return redirect()->to($url)->with('status', 'Vendor profile created!');
    }

    public function dashboard(Request $request)
    {
        $vendors = Vendor::where('user_id', $request->user()->id)
            ->with(['services','bookings','transactions'])
            ->latest()
            ->get();

        // keep first vendor for backwards compatibility in places that expect a single $vendor
        $vendor = $vendors->first();
        $bookings = $vendor ? $vendor->bookings()->latest()->limit(5)->get() : collect();
        $transactions = $vendor ? $vendor->transactions()->latest()->limit(5)->get() : collect();
        $services = $vendor ? $vendor->services : collect();
        return view('vendor/dashboard', compact('vendors','vendor','bookings','transactions','services'));
    }

    public function bookings(Request $request)
    {
        $vendor = Vendor::where('user_id', $request->user()->id)->firstOrFail();
        $bookings = $vendor->bookings()->latest()->paginate(10);
        return view('vendor/bookings', compact('vendor','bookings'));
    }

    public function transactions(Request $request)
    {
        $vendor = Vendor::where('user_id', $request->user()->id)->firstOrFail();
        $transactions = $vendor->transactions()->latest()->paginate(10);
        return view('vendor/transactions', compact('vendor','transactions'));
    }

    public function services(Request $request)
    {
        $vendors = Vendor::where('user_id', $request->user()->id)
            ->with(['services','bookings'])
            ->latest()
            ->get();
        return view('vendor/services', compact('vendors'));
    }

    // Public: search for vendors by filters
    public function search(Request $request)
    {
        $q = Vendor::query();
        if ($request->filled('service')) {
            $q->where(function($qq) use ($request) {
                $s = $request->get('service');
                $qq->where('service_name','LIKE',"%$s%")
                   ->orWhere('service','LIKE',"%$s%")
                   ->orWhere('description','LIKE',"%$s%");
            });
        }
        if ($request->filled('category')) {
            $cat = strtolower($request->get('category'));
            $q->whereRaw('LOWER(category) LIKE ?', ["%$cat%"]);
        }
        if ($request->filled('city')) {
            $q->where('city','LIKE','%'.$request->get('city').'%');
        }
        // Basic ordering: recent first
        $vendors = $q->latest()->limit(30)->get();
        return response()->json($vendors->map(function($v){
            return [
                'id' => $v->id,
                'title' => $v->service_name,
                'subtitle' => $v->subtitle,
                'image' => $v->image_url,
                'discount' => $v->discount_percent,
                'price' => $v->base_price,
                'rating' => $v->rating,
                'service' => $v->service,
                'area' => $v->area,
                'city' => $v->city,
                'pin' => $v->pin_code,
                'contact' => $v->contact_number,
                'services' => $v->services()->pluck('name')->all(),
                'address' => trim(($v->street? $v->street.', ' : '').$v->area.', '.$v->city.' - '.$v->pin_code),
            ];
        }));
    }

    // Public: return distinct cities where vendors exist
    public function cities(Request $request)
    {
        $cities = Vendor::query()
            ->whereNotNull('city')
            ->where('city','!=','')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');
        return response()->json($cities->values());
    }

    public function serviceStore(Request $request)
    {
        $vendor = Vendor::where('user_id', $request->user()->id)->firstOrFail();
        $data = $request->validate(['name' => 'required|string|max:120']);
        $vendor->services()->create($data);
        return back()->with('status','Service added');
    }

    public function serviceUpdate(Request $request, VendorService $service)
    {
        $this->authorizeService($request, $service);
        $data = $request->validate(['name' => 'required|string|max:120']);
        $service->update($data);
        return back()->with('status','Service updated');
    }

    public function serviceDestroy(Request $request, VendorService $service)
    {
        $this->authorizeService($request, $service);
        $service->delete();
        return back()->with('status','Service deleted');
    }

    public function edit(Request $request)
    {
        $vendor = Vendor::where('user_id', $request->user()->id)->firstOrFail();
        return view('vendor/edit', compact('vendor'));
    }

    // Edit a specific vendor (owned by current user)
    public function editVendor(Request $request, Vendor $vendor)
    {
        abort_unless($vendor->user_id === $request->user()->id, 403);
        return view('vendor/edit', compact('vendor'));
    }

    public function update(Request $request)
    {
        $vendor = Vendor::where('user_id', $request->user()->id)->firstOrFail();
        $data = $request->validate([
            'service_name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'base_price' => 'nullable|integer|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'description' => 'nullable|string',
            'pin_code' => 'nullable|string|max:10',
            'area' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4096',
        ]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('vendors', 'public');
            $data['image_path'] = $path;
        }
        unset($data['image']);
        $vendor->update($data);
        return redirect()->route('vendor.dashboard')->with('status','Vendor profile updated');
    }

    // Update a specific vendor
    public function updateVendor(Request $request, Vendor $vendor)
    {
        abort_unless($vendor->user_id === $request->user()->id, 403);
        $data = $request->validate([
            'service_name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'base_price' => 'nullable|integer|min:0',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'description' => 'nullable|string',
            'pin_code' => 'nullable|string|max:10',
            'area' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4096',
        ]);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('vendors', 'public');
            $data['image_path'] = $path;
        }
        unset($data['image']);
        $vendor->update($data);
        return redirect()->route('vendor.dashboard')->with('status','Vendor profile updated');
    }

    // Delete a specific vendor
    public function destroyVendor(Request $request, Vendor $vendor)
    {
        abort_unless($vendor->user_id === $request->user()->id, 403);
        // optionally remove image from storage
        if ($vendor->image_path) {
            try { Storage::disk('public')->delete($vendor->image_path); } catch(\Throwable $e) {}
        }
        $vendor->delete();
        return redirect()->route('vendor.services')->with('status','Business deleted');
    }

    private function authorizeService(Request $request, VendorService $service): void
    {
        $vendor = Vendor::where('user_id', $request->user()->id)->firstOrFail();
        abort_unless($service->vendor_id === $vendor->id, 403);
    }
}
