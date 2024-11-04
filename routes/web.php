<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\GeonameController;

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('frontend.index');
// });
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('backend/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Permission Management
    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions');
        Route::post('/store', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/delete/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');
        Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
        Route::post('/edit/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    });

    // Role Management
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles');
        Route::post('/store', [RoleController::class, 'store'])->name('role.store');
        Route::get('/edit/{id}', [RoleController::class, 'store'])->name('role.edit');
        Route::post('/edit/{id}', [RoleController::class, 'update'])->name('role.update');
        Route::delete('/delete', [RoleController::class, 'destroy'])->name('role.delete');
    });

    // User Management
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::delete('/delete', [UserController::class, 'destroy'])->name('user.delete');
    });

    // Category Management
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories');
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/delete', [CategoryController::class, 'destroy'])->name('category.delete');
    });

    // Product Management
    Route::prefix('products')->group(function () {
        Route::get('/list', [ProductController::class, 'index'])->name('product.list');
        Route::get('/data', [ProductController::class, 'products'])->name('products.data');
        Route::get('/add', [ProductController::class, 'addForm'])->name('product.add');
        Route::post('/add', [ProductController::class, 'store'])->name('product.store');
        Route::delete('/delete', [ProductController::class, 'destroy'])->name('product.delete');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/{id}', [ProductController::class, 'update'])->name('product.update');
    });

    // Image Management
    Route::delete('images/{id}', [ImageController::class, 'destroy'])->name('image.delete');

    // Order Management
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders');
        Route::get('/detail/{id}', [OrderController::class, 'ordersDetail'])->name('orders.detail');
    });
});

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/product', [ShopController::class, 'index'])->name('shop.products');
Route::get('/product/detail/{id}', [ShopController::class, 'productDetail'])->name('product.detail');

// Cart Routes
Route::post('cart/add', [CartController::class, 'addCart'])->name('addCart');
Route::post('cart/delete', [CartController::class, 'destroy'])->name('deleteCart');
Route::get('cart/detail', [CartController::class, 'cartDetail'])->name('cart.detail');

// Checkout Routes
Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout')->middleware('CheckCart');
Route::post('checkout', [CheckoutController::class, 'payment'])->name('stripe.post')->middleware('CheckCart');
Route::get('checkout/thankyou', [CheckoutController::class, 'thankyou'])->name('checkout.thankyou');

// PayPal Routes
Route::post('paypal/payment', [CheckoutController::class, 'payment'])->name('paypal.payment');
Route::get('paypal/payment/success', [CheckoutController::class, 'paymentSuccess'])->name('paypal.payment.success');
Route::get('paypal/payment/cancel', [CheckoutController::class, 'paypalCancel'])->name('paypal.payment.cancel');

// API Routes
Route::get('/api/get-countries', [GeonameController::class, 'getCountries']);
Route::get('/api/get-states/{countryId}', [GeonameController::class, 'getStates']);
Route::get('/api/get-cities/{stateId}', [GeonameController::class, 'getCities']);


require __DIR__.'/auth.php';
