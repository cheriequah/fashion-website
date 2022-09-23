<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\IndexController;
use Illuminate\Support\Facades\Route;
//use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/phpinfo', function() {
    return phpinfo();
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function() {
    // Admin routes
    Route::match(['get','post'],'/',[AdminController::class, 'login'])->name('admin.login');
    Route::group(['middleware' => ['admin']], function() {
        //only authenticated admins may enter
        Route::get('dashboard',[AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('settings',[AdminController::class, 'settings'])->name('admin.settings');
        Route::post('check-current-pw',[AdminController::class, 'chkCurrentPw']);
        Route::get('logout',[AdminController::class, 'logout'])->name('admin.logout');

        // Categories
        Route::get('categories',[CategoryController::class, 'categories'])->name('admin.categories');
        Route::post('update-category-status',[CategoryController::class, 'updateCategoryStatus']);
        // if no id then is add category, if sending id then is edit category route
        // id? means id may or may not have
        Route::match(['get','post'],'add-edit-category/{id?}',[CategoryController::class,'addEditCategory']);
        Route::get('delete-category/{id}',[CategoryController::class, 'deleteCategory']);

        // Products
        Route::get('products',[ProductController::class,'products'])->name('admin.products');
        Route::post('update-product-status',[ProductController::class, 'updateProductStatus']);
        Route::match(['get','post'],'add-edit-product/{id?}',[ProductController::class,'addEditProduct']);
        Route::get('delete-product/{id}',[ProductController::class, 'deleteProduct']);
        Route::get('delete-product-image/{id}',[ProductController::class,'deleteProductImage']);

        //Attributes
        Route::match(['get','post'],'add-attributes/{id}',[ProductController::class,'addAttributes']);
        Route::post('edit-attributes/{id}',[ProductController::class,'editAttributes']);
        Route::post('update-attribute-status',[ProductController::class, 'updateAttributeStatus']);
        Route::get('delete-attribute/{id}',[ProductController::class, 'deleteAttribute']);
    });
});

Route::namespace('App\Http\Controllers\Front')->group(function() {
    Route::get('/',[IndexController::class,'index']);
    //Route::get('/shop',[ProductsController::class,'shop']);
    // Display Products by category
    Route::match(['get','post'],'/shop/{slug}',[ProductsController::class,'products']);
});