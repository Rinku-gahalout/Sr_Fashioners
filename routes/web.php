<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('adminguest')->group(function () {
    route::get('/admin/login',[AdminController::class,'login'])->name('admin.login');
    Route::post('/admin/login/authentication', [AdminController::class, 'authentication'])->name('admin.login.authentication');
});

Route::middleware(['adminauth'])->group(function () {
    route::get('/admin/dashboard',[DashboardController::class,'dashboard'])->name('admin.dashboard');
    route::post('/admin/dashboard',[DashboardController::class,'logout'])->name('admin.logout');

    // category Route
    Route::get('/admin/list/category',[CategoryController::class,'listCategory'])->name('list.category');
    route::get('/admin/category',[CategoryController::class,'AddCategory'])->name('admin.addcategory');
    Route::post('/admin/store/category',[CategoryController::class,'storeCategory'])->name('admin.storecategory');
    route::get('/admin/{categoryid}/edit',[CategoryController::class,'editCategory'])->name('admin.editcategory');
    Route::post('/admin/{categoryid}/update',[CategoryController::class,'updateCategory'])->name('admin.updatecategory');
    Route::delete('/admin/category/{categoryid}/delete',[CategoryController::class,'deleteCategory'])->name('admin.deletecategory');

    // subcategory route
    Route::get('/admin/list/subcategory',[CategoryController::class,'listsubcategory'])->name('list.subcategory');
    Route::get('/admin/subcategory',[CategoryController::class,'addsubcategory'])->name('add.subcategory');
    Route::post('/admin/store/subcategory',[CategoryController::class,'storesubcategory'])->name('store.subcategory');
    route::get('/admin/edit/{id}/subcategory',[CategoryController::class,'editsubcategory'])->name('edit.subcategory');
    route::post('/admin/update/{id}/subcategory',[CategoryController::class,'updatesubcategory'])->name('update.subcategory');
    Route::delete('/admin/delete/{id}/subcategory',[CategoryController::class, 'deletesubcategory'])->name('delete.subcategory');

    // product route
    route::get('/admin/products',[DashboardController::class,'product'])->name('admin.product');
    route::get('/admin/add/product',[DashboardController::class,'addproduct'])->name('add.product');
    route::post('/admin/store/product',[DashboardController::class,'storeproduct'])->name('store.product');
    route::get('/admin/product/{id}/edit',[DashboardController::class,'editproduct'])->name('edit.product');
    route::put('/admin/product/{id}/update',[DashboardController::class,'updateproduct'])->name('update.product');
    Route::delete('/admin/product/{id}', [DashboardController::class, 'deleteproduct'])->name('delete.product');
    Route::delete('/admin/product/gallery-image/{id}', [DashboardController::class, 'deleteGalleryImage'])->name('delete.gallery.image');
    // route::get('/admin/cotton-pants/list',[DashboardController::class,'filteredproductlist'])->name('filterd.product.list');

    // category wise list
    route::get('pant-category/{category}',[DashboardController::class,'list_category'])->name('category.list');

    // fitting list
    Route::get('/admin/fitting/list',[DashboardController::class,'list_fitting'])->name('fitting.list');
    Route::get('/admin/add/fitting',[DashboardController::class,'add_fitting'])->name('add.fitting');
    Route::post('/admin/post/fitting',[DashboardController::class,'store_fitting'])->name('store.fitting');
    Route::get('/admin/{id}/fitting/edit',[DashboardController::class,'edit_fitting'])->name('fittings.edit');
    Route::put('/admin/fitting/{id}/update',[DashboardController::class, 'update_fitting'])->name('fittings.update');
    Route::delete('/admin/fitting/{id}/delete',[DashboardController::class, 'delete_fitting'])->name('fittings.delete');
    Route::get('/admin/coustomer/fitting/{id}/list',[DashboardController::class,'coustomer_fitting_list'])->name('fitting.coustomer.list');

    Route::get('/admin/coustomer/order',[DashboardController::class,'coustomer_order'])->name('coustomer.order');
    Route::patch('/admin/orders/{type}/{id}/status',[DashboardController::class, 'updateOrderStatus'])->name('admin.orders.updateStatus');

    Route::get('/admin/coustomer/list',[DashboardController::class,'coustomer_list'])->name('coustomer.list');
    Route::patch('/admin/customers/{customer}/status',[DashboardController::class, 'updateStatus'])->name('admin.customers.updateStatus');
});

Route::middleware('customer.guest')->group(function () {
    Route::get('/sign-in',[UserAccountController::class,'sign_in'])->name('user.sign.in');
    Route::post('/register', [UserAccountController::class, 'register'])->name('register');
    Route::post('/login', [UserAccountController::class, 'login'])->name('login');
});
Route::middleware('customer.auth')->group(function () {
    Route::get('/user/account',[UserAccountController::class,'profilepage'])->name('user.profile.page');
    Route::get('/wishlist',[WishlistController::class,'wishlist'])->name('user.wishlist');
    Route::post('/wishlist/store', [WishlistController::class, 'store'])->name('wishlist.store')->middleware('auth');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy')->middleware('auth');
    Route::get('/cart/list',[CartController::class,'index'])->name('cart.list'); 
    Route::post('/cart',[CartController::class, 'store'])   ->name('cart.store');
    Route::patch('/cart/{cart}',[CartController::class, 'update'])  ->name('cart.update');
    Route::delete('/cart/{cart}',[CartController::class, 'destroy']) ->name('cart.destroy');   
    Route::post('/logout', [UserAccountController::class, 'logout'])->name('logout');
});

Route::get('/',[HomeController::class,'index'])->name('index');
Route::get('/about-us',[PageController::class,'about_us'])->name('about.us');
Route::get('/contact-us',[PageController::class,'contact_us'])->name('contact.us');
Route::get('/privacy-policy',[PageController::class,'privacy_policy'])->name('privacy.policy');
Route::get('/term-condition',[PageController::class,'term_condition'])->name('term.condition');
Route::get('/b2b-refund-policy',[PageController::class,'refund_policy'])->name('refund.policy');

route::get('/{category}',[HomeController::class,'list'])->name('list');
route::get('/{category}/{product_name}',[HomeController::class,'product_detail'])->name('product.detail');