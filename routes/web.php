<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CareerController;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

Route::get('/', function () { 
    $bannersStr = \Illuminate\Support\Facades\Storage::disk('public')->get('banners.json');
    $banners = $bannersStr ? json_decode($bannersStr, true) : [
        ['title' => 'Mega Sale Live!', 'subtitle' => 'Up to 50% Off on Services', 'bg' => 'bg-1', 'color' => 'text-blue-600', 'btn_text' => 'Book Now', 'link' => '/explore'],
        ['title' => 'Rent Or Buy', 'subtitle' => 'Top properties near you', 'bg' => 'bg-2', 'color' => 'text-orange-600', 'btn_text' => 'Explore', 'link' => '/one-x-one'],
        ['title' => '100% Verified', 'subtitle' => 'Trusted professionals on door', 'bg' => 'bg-3', 'color' => 'text-emerald-600', 'btn_text' => 'Hire Now', 'link' => '/explore'],
    ];

    $categoriesStr = \Illuminate\Support\Facades\Storage::disk('public')->get('categories.json');
    $categories = $categoriesStr ? json_decode($categoriesStr, true) : [
        ['title' => 'Plumber', 'link' => 'Plumber', 'image' => 'image/plumber.png'],
        ['title' => 'Electrician', 'link' => 'Electrician', 'image' => 'image/electrician.png'],
        ['title' => 'Cleaner', 'link' => 'Cleaner', 'image' => 'image/Cleaner.png'],
        ['title' => 'Painter', 'link' => 'Painter', 'image' => 'image/Painter.png'],
    ];

    $servicesStr = \Illuminate\Support\Facades\Storage::disk('public')->get('services.json');
    $services = $servicesStr ? json_decode($servicesStr, true) : [
        [
            'title' => 'Electrician', 'subtitle' => 'Khanna, Ludhiana', 'price' => '₹500',
            'badge' => 'FLAT 20% OFF', 'rating' => '5.0', 'reviews' => '120 Reviews', 'footer' => 'GT Road Khanna, Kulesra, Ludhiana - 141401',
            'link' => '/explore?service=Electrician', 'image' => 'image/car.jpg'
        ],
        [
            'title' => 'Deep Cleaning', 'subtitle' => 'Andheri, Mumbai', 'price' => '₹1200',
            'badge' => 'FLAT 15% OFF', 'rating' => '4.8', 'reviews' => '85 Reviews', 'footer' => 'Lokhandwala Complex, Andheri East - 400053',
            'link' => '/explore?service=Cleaner', 'image' => 'image/drivers.jpg'
        ]
    ];

    $testimonialsStr = \Illuminate\Support\Facades\Storage::disk('public')->get('testimonials.json');
    $testimonials = $testimonialsStr ? json_decode($testimonialsStr, true) : [
        [
            "name" => "Jane Doe", "rating" => "5", "description" => "An amazing platform! I found exactly what I needed in just a few clicks.", "image" => ""
        ]
    ];

    return view('dashboard', compact('banners', 'categories', 'services', 'testimonials'));
})->name('home');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
// Simple registration page (GET) so views can link to a register form
Route::get('/register', function(){ return view('auth.register'); })->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Socialite routes
Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');

// Password reset (built-in) routes


// Request reset link form
Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');

// Send password reset link
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink($request->only('email'));
    return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
})->name('password.email');

// Reset form
Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

// Handle reset
Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:6|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email','password','password_confirmation','token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password),
            ])->setRememberToken(Str::random(60));
            $user->save();
        }
    );

    return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
})->name('password.update');
// Protected routes
Route::middleware('auth')->group(function(){
    Route::get('/profile', function(){ return view('profile'); })->name('profile');
    Route::get('/wallet', function(){
        $user = auth()->user();
        $balance = $user->wallet_balance ?? 0;
        return view('wallet', compact('balance'));
    })->name('wallet');
    // Vendor onboarding and dashboard
    // Vendor entry point (used by profile switch icon)
    Route::get('/vendor', [VendorController::class, 'entry'])->name('vendor.entry');
    Route::get('/become-vendor', [VendorController::class, 'form'])->name('vendor.form');
    Route::post('/become-vendor', [VendorController::class, 'store'])->name('vendor.store');
    Route::get('/vendor/dashboard', [VendorController::class, 'dashboard'])->name('vendor.dashboard');
    Route::get('/vendor/bookings', [VendorController::class, 'bookings'])->name('vendor.bookings');
    Route::get('/vendor/transactions', [VendorController::class, 'transactions'])->name('vendor.transactions');
    Route::get('/vendor/services', [VendorController::class, 'services'])->name('vendor.services');
    Route::post('/vendor/services', [VendorController::class, 'serviceStore'])->name('vendor.services.store');
    Route::put('/vendor/services/{service}', [VendorController::class, 'serviceUpdate'])->name('vendor.services.update');
    Route::delete('/vendor/services/{service}', [VendorController::class, 'serviceDestroy'])->name('vendor.services.destroy');
    // vendor resource operations for multiple businesses
    Route::get('/vendor/{vendor}/edit', [VendorController::class, 'editVendor'])->name('vendor.edit');
    Route::put('/vendor/{vendor}', [VendorController::class, 'updateVendor'])->name('vendor.update');
    Route::delete('/vendor/{vendor}', [VendorController::class, 'destroyVendor'])->name('vendor.destroy');
    Route::get('/vendor/profile/edit', [VendorController::class, 'edit'])->name('vendor.profile.edit');
    // Accept both POST and PUT for the profile update endpoint.
    // Some clients or middlewares may submit as POST without method-spoofing;
    // adding a POST fallback prevents a hard 404 while preserving PUT as primary.
    Route::post('/vendor/profile', [VendorController::class, 'update'])->name('vendor.profile.post');
    Route::put('/vendor/profile', [VendorController::class, 'update'])->name('vendor.profile.update');

    // Sell and Rent Items
    Route::get('/vendor/items/sell', [App\Http\Controllers\ItemController::class, 'createSell'])->name('vendor.items.sell');
    Route::get('/vendor/items/rent', [App\Http\Controllers\ItemController::class, 'createRent'])->name('vendor.items.rent');
    Route::post('/vendor/items', [App\Http\Controllers\ItemController::class, 'store'])->name('vendor.items.store');
    
    // Edit & delete items
    Route::get('/vendor/items/{item}/edit', [App\Http\Controllers\ItemController::class, 'edit'])->name('vendor.items.edit');
    Route::put('/vendor/items/{item}', [App\Http\Controllers\ItemController::class, 'update'])->name('vendor.items.update');
    Route::delete('/vendor/items/{item}', [App\Http\Controllers\ItemController::class, 'destroy'])->name('vendor.items.destroy');
});

// Public vendor search API (JSON)
Route::get('/api/vendors', [VendorController::class, 'search'])->name('vendors.search');
// Public: vendor cities
Route::get('/api/vendor-cities', [VendorController::class, 'cities'])->name('vendors.cities');

// Account management routes (protected)
Route::middleware('auth')->group(function(){
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::post('/account', [AccountController::class, 'update'])->name('account.update');
    Route::get('/refer-earn', [\App\Http\Controllers\ReferralController::class, 'show'])->name('refer.earn');
});

// removed duplicate public profile route

// Public explore / landing page for features like Rent Houses and Expense Management
Route::view('/explore', 'explore')->name('explore');
Route::get('/professional/{id}', [App\Http\Controllers\VendorController::class, 'show'])->name('professional.show');


// Simple page for the 1X1 quick-links (opened from mobile footer)
Route::get('/one-x-one', function (\Illuminate\Http\Request $request) {
    $query = \App\Models\Item::with('user')->where('status', 'active');
    
    if ($request->filled('q')) {
        $query->where(function($q) use ($request) {
            $q->where('title', 'like', '%' . $request->q . '%')
              ->orWhere('description', 'like', '%' . $request->q . '%')
              ->orWhere('location_text', 'like', '%' . $request->q . '%')
              ->orWhere('category', 'like', '%' . $request->q . '%');
        });
    }

    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    $items = $query->latest()->get();
    return view('partials.one-x-one', compact('items'));
})->name('one_x_one');

// Expense Management (DB-backed)
use App\Http\Controllers\ExpenseController;
Route::middleware('auth')->group(function(){
    Route::get('/expense-management', [ExpenseController::class, 'index'])->name('expense.index');
    Route::post('/expense-management/groups', [ExpenseController::class, 'storeGroup'])->name('expense.groups.store');
    Route::post('/expense-management/groups/{group}/expenses', [ExpenseController::class, 'storeExpense'])->name('expense.groups.expenses.store');
    Route::post('/expense-management/groups/{group}/invite', [ExpenseController::class, 'invite'])->name('expense.groups.invite');
    Route::post('/expense-management/groups/{group}/leave', [ExpenseController::class, 'leave'])->name('expense.groups.leave');
    Route::get('/expense-management/groups/{group}/settle', [ExpenseController::class, 'settle'])->name('expense.groups.settle');
    Route::post('/expense-management/groups/{group}/settle', [ExpenseController::class, 'doSettle'])->name('expense.groups.doSettle');
    Route::get('/expense-management/groups/{group}/report', [ExpenseController::class, 'report'])->name('expense.groups.report');
    Route::get('/expense-management/groups/create', [ExpenseController::class, 'create'])->name('expense.groups.create');
    Route::get('/expense-management/groups/{group}', [ExpenseController::class, 'show'])->name('expense.groups.show');
    Route::post('/expense-management/groups/{group}/image', [ExpenseController::class, 'updateImage'])->name('expense.groups.image');
    Route::delete('/expense-management/expenses/{expense}', [ExpenseController::class, 'destroyExpense'])->name('expense.delete');
    Route::put('/expense-management/expenses/{expense}', [ExpenseController::class, 'updateExpense'])->name('expense.update');
    Route::delete('/expense-management/groups/{group}', [ExpenseController::class, 'destroy'])->name('expense.groups.destroy');
});

// Public invite accept link (invitees can open this; they'll be prompted to login if needed)
Route::get('/expense-management/invite/accept/{token}', [ExpenseController::class, 'acceptInvite'])->name('expense.invite.accept');


// Careers application
Route::get('/careers', [CareerController::class, 'show'])->name('careers.show');
Route::post('/careers', [CareerController::class, 'submit'])->name('careers.submit');


Route::post('/save-location', [App\Http\Controllers\LocationController::class, 'saveLocation'])->name('save.location');


Route::post('/save-location', [App\Http\Controllers\LocationController::class, 'saveLocation'])->name('save.location');


Route::post('/bookings', [App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
Route::get('/my-bookings', [App\Http\Controllers\BookingController::class, 'userBookings'])->name('my.bookings');
Route::put('/vendor/bookings/{booking}/status', [App\Http\Controllers\BookingController::class, 'updateStatus'])->name('vendor.bookings.update');


// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/banners', [\App\Http\Controllers\AdminController::class, 'updateBanners'])->name('admin.banners.update');
    Route::post('/admin/categories', [\App\Http\Controllers\AdminController::class, 'updateCategories'])->name('admin.categories.update');
    Route::post('/admin/services', [\App\Http\Controllers\AdminController::class, 'updateServices'])->name('admin.services.update');
    Route::post('/admin/testimonials', [\App\Http\Controllers\AdminController::class, 'updateTestimonials'])->name('admin.testimonials.update');
});
