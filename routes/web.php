<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\DiscountBannerController;
use App\Http\Controllers\Backend\ServiceController;
use App\Http\Controllers\Backend\InstagramPostController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Backend\BlogCategoryController;
use App\Http\Controllers\Backend\BlogManagementController;
use App\Http\Controllers\Backend\ReportController;
/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/product/{slug}', [ShopController::class, 'show'])->name('product.details');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/summary', [CartController::class, 'getCartSummary'])->name('cart.summary');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.place-order');
Route::get('/checkout/success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/order-track', [CheckoutController::class, 'trackForm'])->name('order.track');
Route::post('/order-track', [CheckoutController::class, 'trackOrder'])->name('order.track.post');

// Contact Routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
// Wishlist Routes
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::post('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');
Route::get('/wishlist/count', [WishlistController::class, 'getCount'])->name('wishlist.count');
Route::post('/wishlist/check', [WishlistController::class, 'check'])->name('wishlist.check');
// Static Pages
Route::get('/about', function () {
    return view('frontend.about');
})->name('about');

// Blog Routes (Dynamic)
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.details');
Route::post('/blog/{slug}/comment', [BlogController::class, 'storeComment'])->name('blog.comment.store');
Route::get('/blog-search', [BlogController::class, 'search'])->name('blog.search');

// // Blog Routes (Static for now)
// Route::get('/blog', function () {
//     return view('frontend.blog');
// })->name('blog');

// Route::get('/blog-details', function () {
//     return view('frontend.blog-details');
// })->name('blog.details');

// // About Page (Static)
// Route::get('/about', function () {
//     return view('frontend.about');
// })->name('about');

// // FAQ Page (Static)
// Route::get('/faq', function () {
//     return view('frontend.faq');
// })->name('faq');

// // Terms & Conditions (Static)
// Route::get('/terms', function () {
//     return view('frontend.terms');
// })->name('terms');

// // Privacy Policy (Static)
// Route::get('/privacy', function () {
//     return view('frontend.privacy');
// })->name('privacy');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Admin Login Routes (no auth required)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// Protected Admin Routes (require admin auth)
Route::prefix('admin')->name('admin.')->group(function () {
    // Logout route (should be accessible when logged in)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected routes with auth middleware
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Dashboard Chart Data
        Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData'])->name('dashboard.chart-data');

        // Categories
        Route::resource('categories', CategoryController::class);
        Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
        Route::post('categories/update-order', [CategoryController::class, 'updateOrder'])->name('categories.update-order');

        // Sub Categories
        Route::resource('subcategories', SubCategoryController::class);
        Route::get('subcategories-by-category/{categoryId}', [SubCategoryController::class, 'getByCategory'])->name('subcategories.by-category');

        // Products
        Route::resource('products', ProductController::class);
        Route::post('products/{product}/update-stock', [ProductController::class, 'updateStock'])->name('products.update-stock');
        Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');

        // Orders
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
        Route::get('orders/{order}/invoice', [OrderController::class, 'printInvoice'])->name('orders.invoice');

        // Settings
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

        // Banners (Add this new route group)
        Route::resource('banners', BannerController::class);
        Route::post('banners/{banner}/toggle-status', [BannerController::class, 'toggleStatus'])->name('banners.toggle-status');
        // Discount Banners
        Route::resource('discount-banners', DiscountBannerController::class);
        Route::post('discount-banners/{discountBanner}/toggle-status', [DiscountBannerController::class, 'toggleStatus'])->name('discount-banners.toggle-status');
        // Services
        Route::resource('services', ServiceController::class);
        Route::post('services/{service}/toggle-status', [ServiceController::class, 'toggleStatus'])->name('services.toggle-status');
        // Instagram Posts
        Route::resource('instagram-posts', InstagramPostController::class);
        Route::post('instagram-posts/{instagramPost}/toggle-status', [InstagramPostController::class, 'toggleStatus'])->name('instagram-posts.toggle-status');
        // Blog Management Routes
        Route::resource('blogs', BlogManagementController::class);
        Route::post('blogs/{blog}/toggle-status', [BlogManagementController::class, 'toggleStatus'])->name('blogs.toggle-status');
        Route::post('blogs/{blog}/toggle-featured', [BlogManagementController::class, 'toggleFeatured'])->name('blogs.toggle-featured');

        // Blog Comments Routes
        Route::get('blog-comments', [BlogManagementController::class, 'comments'])->name('blog-comments.index');
        Route::post('blog-comments/{comment}/toggle-approval', [BlogManagementController::class, 'toggleCommentApproval'])->name('blog-comments.toggle-approval');
        Route::delete('blog-comments/{comment}', [BlogManagementController::class, 'destroyComment'])->name('blog-comments.destroy');

        // Blog Categories Routes
        Route::resource('blog-categories', BlogCategoryController::class);
        Route::post('blog-categories/{blogCategory}/toggle-status', [BlogCategoryController::class, 'toggleStatus'])->name('blog-categories.toggle-status');

        // Reports Routes
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

        // Contact Messages Routes
        Route::get('contact-messages', [App\Http\Controllers\Backend\ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('contact-messages/{id}', [App\Http\Controllers\Backend\ContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::post('contact-messages/{id}/toggle-read', [App\Http\Controllers\Backend\ContactMessageController::class, 'toggleRead'])->name('contact-messages.toggle-read');
        Route::delete('contact-messages/{id}', [App\Http\Controllers\Backend\ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
    });
});

/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return view('frontend.404');
});
