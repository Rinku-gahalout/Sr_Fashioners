<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

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