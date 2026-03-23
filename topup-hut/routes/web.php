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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/search', [ShopController::class, 'search'])->name('shop.search');
Route::get('/shop/category/{slug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/product/{slug}', [FrontendProductController::class, 'show'])->name('product');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page');

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
