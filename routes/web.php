<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Front\BotManController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\OrdersController;
use App\Http\Controllers\Front\ReviewsController;
use App\Http\Controllers\Front\UsersController;
use App\Models\Category;
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

Route::get('/liveagent', function () {
    return view('welcome');
});
Route::match(['GET','POST'],'/botman',[BotManController::class,'handle']);

Route::get('/phpinfo', function() {
    return phpinfo();
});

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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

        // Attributes
        Route::match(['get','post'],'add-attributes/{id}',[ProductController::class,'addAttributes']);
        Route::post('edit-attributes/{id}',[ProductController::class,'editAttributes']);
        Route::post('update-attribute-status',[ProductController::class, 'updateAttributeStatus']);
        Route::get('delete-attribute/{id}',[ProductController::class, 'deleteAttribute']);

        // Orders
        Route::get('orders',[OrderController::class, 'orders'])->name('admin.orders');
        Route::get('orders/{id}',[OrderController::class, 'orderDetails']);
        Route::post('update-order-status',[OrderController::class, 'updateOrderStatus']);
        Route::get('view-order-invoice/{id}',[OrderController::class, 'viewOrderInvoice']);
        Route::get('print-pdf-invoice/{id}',[OrderController::class, 'printPDFInvoice']);
        
        // Reviews
        Route::get('reviews',[ReviewController::class, 'reviews'])->name('admin.reviews');
        Route::post('update-review-status',[ReviewController::class, 'updateReviewStatus']);
        
    });
});

Route::namespace('App\Http\Controllers\Front')->group(function() {
    Route::get('/',[IndexController::class,'index'])->name('index');
    Route::get('/shop',[ProductsController::class,'shop']);

    // Display Products by category
    $catSlug = Category::select('slug')->where('status',1)->get()->pluck('slug')->toArray();
    //echo "<pre>"; print_r($catSlug); die;
    foreach ($catSlug as $slug) {
        Route::match(['get','post'],'/'.$slug,[ProductsController::class,'products']);
    }

    // Product Detail
    Route::get('/product/{id}',[ProductsController::class,'productDetail'])->name('product-details');

    // Get Product Attribute Price
    Route::post('/get-product-price',[ProductsController::class,'getProductPrice']);

    // Add to Cart
    Route::post('/add-to-cart',[ProductsController::class,'addToCart']);

    Route::get('/cart',[ProductsController::class,'cart'])->name('cart');
    
    // Update cart item quantity
    Route::post('/update-qty-cart-item',[ProductsController::class,'updateQtyCartItem']);

    // Remove Cart Item
    Route::post('/remove-cart-item',[ProductsController::class,'removeCartItem']);

    // Login/ Register page
    Route::get('/login-register',[UsersController::class,'loginRegister'])->name('login-register');

    // Register User
    Route::post('/register',[UsersController::class,'registerUser'])->name('user.register');

    // Login User
    Route::post('/login',[UsersController::class,'loginUser'])->name('user.login');

    // Confirm Account for activation
    Route::match(['GET','POST'],'/confirm/{code}',[UsersController::class,'confirmAccount']);

    Route::match(['get','post'],'add-review',[ReviewsController::class, 'addReview']);
    
    // When a request hits application, it pull out botman instances and listen for any incoming commads
    /*Route::post('/botman', function() {
        app('botman')->listen();
    });*/
    Route::match(['GET','POST'],'/size-calculator',[UsersController::class,'sizeCalculator'])->name('calculator');
    //Route::post('/size-calculator-tops',[UsersController::class,'sizeCalculatorTops'])->name('calculatorTops');
    //Route::post('/size-calculator-bottoms',[UsersController::class,'sizeCalculatorBottoms'])->name('calculatorBottoms');

    // If not authenticate redirect to login/register (authenticate.php)
    Route::group(['middleware'=>['auth']],function() {
        // Logout User
        Route::get('/logout',[UsersController::class,'logoutUser'])->name('logoutUser');   

        // User account 
        Route::match(['GET','POST'],'/account',[UsersController::class,'account'])->name('account');

        // Users Order
        Route::get('/orders',[OrdersController::class,'orders'])->name('order');

        // Users Order
        Route::get('/orders/{id}',[OrdersController::class,'orderDetails']);

        // User preferences
        Route::match(['GET','POST'],'/preferences',[UsersController::class,'preferences'])->name('preferences');

        Route::match(['GET','POST'],'/checkout',[ProductsController::class,'checkout'])->name('checkout');

        Route::match(['GET','POST'],'/add-edit-delivery-address/{id?}',[ProductsController::class,'addEditDeliveryAddress']);

        Route::get('/remove-delivery-address/{id}',[ProductsController::class,'removeDeliveryAddress']);

        Route::get('/thanks',[ProductsController::class,'thanks']);     

        Route::match(['GET','POST'],'/measurement',[UsersController::class,'measurement'])->name('measurement');
    });
    
});