<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\CareerController;

Route::get('/', function () { return view('dashboard'); })->name('home');

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
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

// Simple page for the 1X1 quick-links (opened from mobile footer)
Route::view('/one-x-one', 'partials.one-x-one')->name('one_x_one');

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
    Route::delete('/expense-management/groups/{group}', [ExpenseController::class, 'destroy'])->name('expense.groups.destroy');
});

// Public invite accept link (invitees can open this; they'll be prompted to login if needed)
Route::get('/expense-management/invite/accept/{token}', [ExpenseController::class, 'acceptInvite'])->name('expense.invite.accept');


// Careers application
Route::get('/careers', [CareerController::class, 'show'])->name('careers.show');
Route::post('/careers', [CareerController::class, 'submit'])->name('careers.submit');

