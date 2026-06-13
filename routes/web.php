<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\OrderController;

// =========================================================================
// SECURITY: Admin prefix configuration
// =========================================================================
// Get the admin prefix from .env file (should be like: admin-ebb22fb1a689e3ed)
$adminPrefix = env('ADMIN_PREFIX', 'secure-' . substr(md5(env('APP_KEY')), 0, 16));

// Helper function for admin URL (used in views)
if (!function_exists('admin_url')) {
    function admin_url($path = '') {
        $prefix = env('ADMIN_PREFIX', 'admin');
        return url($prefix . ($path ? '/' . $path : ''));
    }
}

// Trap common admin paths to fool bots (all return 404)
Route::any('/admin', function() {
    abort(404);
})->name('admin.trap');

Route::any('/admin/login', function() {
    abort(404);
});

Route::any('/administrator', function() {
    abort(404);
});

Route::any('/wp-admin', function() {
    abort(404);
});

// Reset route (keep for development)
Route::get('/reset', function () {
    if (! app()->environment('local', 'testing')) {
        abort(403, 'Not allowed outside local/testing.');
    }
    Artisan::call('optimize:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    return '<h3 style="color: blue;">All Reset completed! ✓</h3>' .
           '<pre>' . Artisan::output() . '</pre>';
});

// =========================================================================
// Frontend Routes
// =========================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category');
Route::get('/product/{slug}', [HomeController::class, 'product'])->name('product');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/category/{slug}', [ShopController::class, 'filterByCategory'])->name('shop.category');
Route::get('/shop/tag/{tag}', [ShopController::class, 'filterByTag'])->name('shop.tag');

// Brand Routes
Route::get('/brands', [BrandController::class, 'index'])->name('brands');
Route::get('/brand/{slug}', [BrandController::class, 'show'])->name('brand.show');

// Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Contact Routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Cart routes
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/order-confirmation/{order?}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');

// Wishlist Routes
Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/add', [App\Http\Controllers\WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove', [App\Http\Controllers\WishlistController::class, 'remove'])->name('wishlist.remove');
Route::post('/wishlist/toggle', [App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::get('/wishlist/check/{product}', [App\Http\Controllers\WishlistController::class, 'check'])->name('wishlist.check');
Route::get('/wishlist/count', [App\Http\Controllers\WishlistController::class, 'count'])->name('wishlist.count');
Route::post('/wishlist/clear', [App\Http\Controllers\WishlistController::class, 'clear'])->name('wishlist.clear');
Route::post('/wishlist/batch-check', [App\Http\Controllers\WishlistController::class, 'batchCheck'])->name('wishlist.batch-check');

// Order Tracking Routes
Route::prefix('track')->name('order.')->group(function () {
    Route::get('/', [OrderTrackingController::class, 'index'])->name('track');
    Route::get('/{order}', [OrderTrackingController::class, 'index'])->name('track.number');
    Route::post('/', [OrderTrackingController::class, 'track'])->name('track.post');
});

// Tracking API Routes
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/track/{orderNumber}', [OrderTrackingController::class, 'apiTrack'])->name('track');
});

// Review routes
Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('product.review');

// =========================================================================
// Secure Admin Routes - Hidden behind random prefix from .env
// Your admin URL will be: https://dominagde.com/admin-ebb22fb1a689e3ed/login
// =========================================================================
Route::prefix($adminPrefix)->name('admin.')->group(function () {
    // Public admin routes (login)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected admin routes (require authentication)
    Route::middleware(['admin'])->group(function () {
        // Dashboard Routes
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/stats', [DashboardController::class, 'getStats'])->name('dashboard.stats');
        Route::get('/dashboard/recent-orders', [DashboardController::class, 'getRecentOrders'])->name('dashboard.recent-orders');
        Route::get('/dashboard/pending-reviews', [DashboardController::class, 'getPendingReviews'])->name('dashboard.pending-reviews');

        // Category Routes
        Route::resource('categories', CategoryController::class);

        // Notification routes for polling
        Route::get('/notifications/count', [DashboardController::class, 'getNotificationCount'])->name('notifications.count');
        Route::get('/notifications/recent', [DashboardController::class, 'getRecentNotifications'])->name('notifications.recent');

        // Product Routes
        Route::resource('products', ProductController::class);
        Route::post('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])
            ->name('products.toggle-status');

        // Review Routes (Admin)
        Route::resource('reviews', AdminReviewController::class);
        Route::patch('/reviews/{review}/approve', [AdminReviewController::class, 'approve'])
            ->name('reviews.approve');
        Route::patch('/reviews/{review}/reject', [AdminReviewController::class, 'reject'])
            ->name('reviews.reject');

       // Order Routes (Admin)
Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    Route::post('/{order}/update-status', [OrderController::class, 'updateStatus'])->name('update-status');
    Route::post('/{order}/update-tracking', [OrderController::class, 'updateTracking'])->name('update-tracking');
    Route::post('/{order}/update-payment', [OrderController::class, 'updatePayment'])->name('update-payment');
    Route::post('/{order}/add-tracking', [OrderController::class, 'addTrackingUpdate'])->name('add-tracking');
    Route::post('/{order}/add-notes', [OrderController::class, 'addNotes'])->name('add-notes');
    Route::get('/{order}/invoice', [OrderController::class, 'generateInvoice'])->name('invoice');
    Route::post('/bulk', [OrderController::class, 'bulk'])->name('bulk');
    Route::get('/export', [OrderController::class, 'export'])->name('export');
    Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
    
    // Add this new route for deleting tracking entries
    Route::delete('/tracking/{tracking}', [OrderController::class, 'deleteTracking'])->name('delete-tracking');
});

        // Settings Routes
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingsController::class, 'index'])->name('index');
            Route::put('/general', [SettingsController::class, 'updateGeneral'])->name('general');
            Route::put('/profile', [SettingsController::class, 'updateProfile'])->name('profile');
            Route::put('/password', [SettingsController::class, 'updatePassword'])->name('password');
            Route::put('/store', [SettingsController::class, 'updateStore'])->name('store');
            Route::put('/payment', [SettingsController::class, 'updatePayment'])->name('payment');
            Route::put('/shipping', [SettingsController::class, 'updateShipping'])->name('shipping');
        });
    });
});

// =========================================================================
// Static Pages Routes
// =========================================================================
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/faqs', function () {
    return view('faqs');
})->name('faqs');

Route::get('/shipping-policy', function () {
    return view('shipping-policy');
})->name('shipping-policy');

Route::get('/return-policy', function () {
    return view('return-policy');
})->name('return-policy');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/terms-of-service', function () {
    return view('terms-of-service');
})->name('terms-of-service');

Route::get('/payment-methods', function () {
    return view('payment-methods');
})->name('payment-methods');

Route::get('/sitemap', function () {
    return view('sitemap');
})->name('sitemap');

Route::get('/debug-key', function() {
    return response()->json([
        'APP_KEY from env' => env('APP_KEY'),
        'APP_KEY length' => strlen(env('APP_KEY') ?? ''),
        'admin_prefix_calculated' => 'secure-' . substr(md5(env('APP_KEY')), 0, 16),
        'admin_prefix_from_env' => env('ADMIN_PREFIX'),
        'md5 of empty string' => md5(''),
    ]);
});

