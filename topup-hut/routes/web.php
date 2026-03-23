<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/search', [ShopController::class, 'search'])->name('shop.search');
Route::get('/shop/category/{slug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/product/{slug}', [FrontendProductController::class, 'show'])->name('product');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page');

// Serve images from storage directly
Route::get('/storage/{path}', function($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (file_exists($fullPath)) {
        return response()->file($fullPath);
    }
    abort(404);
})->where('path', '.*');

// Temporary route to create pages
Route::get('/setup-pages', function() {
    \App\Models\Page::updateOrCreate(['slug' => 'about-us'], [
        'title' => 'About Us',
        'content' => '<h1 class="text-center mb-4">About Paycardo Shop</h1><p class="lead text-center">Your trusted online top-up store in Bangladesh.</p><p>We provide instant delivery for gaming credits, social media services, visa cards, subscriptions, and more.</p>',
        'status' => 1
    ]);
    \App\Models\Page::updateOrCreate(['slug' => 'contact-us'], [
        'title' => 'Contact Us',
        'content' => '<h1 class="text-center mb-4">Contact Us</h1><div class="row"><div class="col-md-6"><h4>Contact Information</h4><p class="mt-3"><i class="fas fa-envelope me-2"></i> Email: wmzarafat@gmail.com</p><p><i class="fas fa-phone me-2"></i> Phone: +8801850603187</p><p><i class="fab fa-whatsapp me-2"></i> WhatsApp: +8801850603187</p><p><i class="fas fa-map-marker-alt me-2"></i> Address: Dhaka, Bangladesh</p></div></div>',
        'status' => 1
    ]);
    \App\Models\Page::updateOrCreate(['slug' => 'privacy-policy'], [
        'title' => 'Privacy Policy',
        'content' => '<h1 class="text-center mb-4">Privacy Policy</h1><p>Last updated: 2024</p><p>We collect information you provide directly to us. We use the information to process orders and improve our services.</p>',
        'status' => 1
    ]);
    \App\Models\Page::updateOrCreate(['slug' => 'terms-conditions'], [
        'title' => 'Terms & Conditions',
        'content' => '<h1 class="text-center mb-4">Terms & Conditions</h1><p>By accessing Paycardo Shop, you agree to our terms. All products are subject to availability.</p>',
        'status' => 1
    ]);
    return 'Pages created! <a href="/page/contact-us">Go to Contact Us</a>';
});

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order/success/{id}', [CheckoutController::class, 'success'])->name('order.success');

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/logout', [App\Http\Controllers\Auth\LogoutController::class, 'logout'])->name('logout');

Route::get('/auth/google', function() {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function() {
    try {
        $user = Socialite::driver('google')->user();
        
        $existingUser = \App\Models\User::where('email', $user->getEmail())->first();
        
        if ($existingUser) {
            Auth::login($existingUser);
        } else {
            $newUser = \App\Models\User::create([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => bcrypt(str_random(16)),
                'phone' => '',
            ]);
            Auth::login($newUser);
        }
        
        return redirect()->route('account.index')->with('success', 'Logged in successfully!');
    } catch (\Exception $e) {
        return redirect()->route('login')->with('error', 'Google login failed. Please try again.');
    }
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::delete('products/images/{id}', [ProductController::class, 'deleteImage'])->name('products.images.delete');
    Route::post('products/images/{id}/primary', [ProductController::class, 'setPrimaryImage'])->name('products.images.primary');
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'destroy']);
    Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::resource('users', UserController::class)->only(['index', 'show']);
    Route::resource('pages', AdminPageController::class);
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');
});

Route::middleware(['auth'])->prefix('my-account')->name('account.')->group(function () {
    Route::get('/', function () {
        return view('frontend.dashboard');
    })->name('index');
    
    Route::get('/orders', function () {
        $orders = \App\Models\Order::where('user_id', auth()->id())->with('items')->latest()->paginate(10);
        return view('frontend.my-orders', compact('orders'));
    })->name('orders');
});

Route::get('/my-orders', function () {
    return redirect()->route('account.orders');
})->name('my.orders');

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('dashboard.index');
})->name('dashboard');
