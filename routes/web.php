<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
if(App::environment('production')){
    URL::forceScheme('https');
}
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//route client
Route::get('/', [HomeController::class, 'index'])->name('client.home');

Route::get('product/{category_id}', [ClientProductController::class, 'index'])->name('client.products.index');
Route::get('product-detail/{slug}', [ClientProductController::class, 'show'])->name('client.products.show');
Route::get('product', [ClientProductController::class, 'listSearch'])->name('client.product.index');
Route::get('product-search', [ClientProductController::class, 'autocompleteSearch'])->name('client.products.autocomplete');
Route::get('/product/filter-by-category', [ProductController::class, 'filterByCategory'])->name('products.filterByCategory');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('add-to-cart', [CartController::class, 'store'])->name('client.carts.add');
    Route::get('carts', [CartController::class, 'index'])->name('client.carts.index');
    Route::post('update-quantity-product-in-cart/{cart_product_id}', [CartController::class, 'updateQuantityProduct'])->name('client.carts.update_product_quantity');
    Route::post('remove-product-in-cart/{cart_product_id}', [CartController::class, 'removeProductInCart'])->name('client.carts.remove_product');
    Route::post('apply-coupon', [CartController::class, 'applyCoupon'])->name('client.carts.apply_coupon');
    Route::get('checkout', [CartController::class, 'checkout'])->name('client.checkout.index')->middleware('user.can_checkout_cart');
    Route::post('process-checkout', [CartController::class, 'processCheckout'])->name('client.checkout.proccess');

    Route::get('list-orders', [OrderController::class, 'index'])->name('client.orders.index');
    Route::post('orders/cancel/{id}', [OrderController::class, 'cancel'])->name('client.orders.cancel');
});





Auth::routes(['verify' => true]);


//route admin
Route::middleware('auth','redirectIfUser')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::resource('roles', RoleController::class);
    // Route::resource('users', UserController::class);
    // Route::resource('categories', CategoryController::class);
    // Route::resource('products', ProductController::class);
    // Route::resource('coupons', CouponController::class);

    // Route::resource('roles', RoleController::class);
    Route::prefix('roles')->controller(RoleController::class)->name('roles.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('role:super-admin');
        Route::post('/', 'store')->name('store')->middleware('role:super-admin');
        Route::get('/create', 'create')->name('create')->middleware('role:super-admin');
        Route::get('/{role}', 'show')->name('show')->middleware('role:super-admin');
        Route::put('/{role}', 'update')->name('update')->middleware('role:super-admin');
        Route::delete('/{role}', 'destroy')->name('destroy')->middleware('role:super-admin');
        Route::get('/{role}/edit', 'edit')->name('edit')->middleware('role:super-admin');
    });


    // Route::resource('users', UserController::class);
    Route::prefix('users')->controller(UserController::class)->name('users.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:show-user');
        Route::post('/', 'store')->name('store')->middleware('permission:create-user');
        Route::get('/create', 'create')->name('create')->middleware('permission:create-user');
        Route::get('/{user}', 'show')->name('show')->middleware('permission:show-user');
        Route::put('/{user}', 'update')->name('update')->middleware('permission:update-user');
        Route::delete('/{user}', 'destroy')->name('destroy')->middleware('permission:delete-user');
        Route::get('/{user}/edit', 'edit')->name('edit')->middleware('permission:update-user');
    });
    // Route::resource('categories', CategoryController::class);
    Route::prefix('categories')->controller(CategoryController::class)->name('categories.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:show-category');
        Route::post('/', 'store')->name('store')->middleware('permission:create-category');
        Route::get('/create', 'create')->name('create')->middleware('permission:create-category');
        Route::get('/{category}', 'show')->name('show')->middleware('permission:show-category');
        Route::put('/{category}', 'update')->name('update')->middleware('permission:update-category');
        Route::delete('/{category}', 'destroy')->name('destroy')->middleware('permission:delete-category');
        Route::get('/{category}/edit', 'edit')->name('edit')->middleware('permission:update-category');
    });

    // Route::resource('products', ProductController::class);

    Route::prefix('products')->controller(ProductController::class)->name('products.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:show-product');
        Route::post('/', 'store')->name('store')->middleware('permission:create-product');
        Route::get('/create', 'create')->name('create')->middleware('permission:create-product');
        Route::get('/{product}', 'show')->name('show')->middleware('permission:show-product');
        Route::put('/{product}', 'update')->name('update')->middleware('permission:update-product');
        Route::delete('/{product}', 'destroy')->name('destroy')->middleware('permission:delete-product');
        Route::get('/{product}/edit', 'edit')->name('edit')->middleware('permission:update-product');
        
    });


    Route::prefix('coupons')->controller(CouponController::class)->name('coupons.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('permission:show-coupon');
        Route::post('/', 'store')->name('store')->middleware('permission:create-coupon');
        Route::get('/create', 'create')->name('create')->middleware('permission:create-coupon');
        Route::get('/{coupon}', 'show')->name('show')->middleware('permission:show-coupon');
        Route::put('/{coupon}', 'update')->name('update')->middleware('permission:update-coupon');
        Route::delete('/{coupon}', 'destroy')->name('destroy')->middleware('permission:delete-coupon');
        Route::get('/{coupon}/edit', 'edit')->name('edit')->middleware('permission:update-coupon');
    });


    Route::get('orders', [AdminOrderController::class, 'index'])->name('admin.orders.index')->middleware('permission:list-order');
    Route::post('update-status/{id}', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update_status')->middleware('permission:update-order-status');
});
