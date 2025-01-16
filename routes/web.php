<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CataloguePageController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomePageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Middleware\EnsureGuestUuid;
use App\Http\Middleware\AdminMiddleware;

Route::middleware([EnsureGuestUuid::class])->group(function () {
    Route::get('/', [WelcomePageController::class, 'welcome'])->name('welcome');
    //show by genre
    Route::get('/games/{genre}', [WelcomePageController::class, 'showByGenre'])->name('gamesbyGenre');
    //get catalogue
    Route::get('catalogue/catalogue', [WelcomePageController::class, 'getCatalogue'])->name('getCatalogue');
    //get catalogue item
    Route::get('/catalogue/{id}', [CataloguePageController::class, 'getItem'])->name('getitem');
    //filter catalogue
    Route::post('/catalogue/filter', [CataloguePageController::class, 'filter'])->name('filtercata');
    //seach catalogue
    Route::post('/catalogue/catalogue/search', [CataloguePageController::class, 'search'])->name('searchcatalogue');
    //get customer sales page
    Route::get('/user/sales', [WelcomePageController::class, 'hotsales'])->name('hotsales');
    //contact email
    Route::post('/user/contactus/email', [MailController::class, 'sendquery'])->name('contactusemail');
    //addcart
    Route::post('/addtocart', [CartController::class, 'addcart'])->name('addcart');
     //increasecart
     Route::post('/increasecart', [CartController::class, 'increaseQuantity'])->name('increasecart');
     //decreasecart
     Route::post('/decreasecart', [CartController::class, 'decreaseQuantity'])->name('decreasecart');
      //deleteitemcart
      Route::delete('/deletecartitem/{id}', [CartController::class, 'deletecartitem'])->name('deletecartitem');
    //getCart
    Route::get('/user/getcart', [CartController::class, 'getCart'])->name('getCart');
    //login page
    Route::get('/user/login', [WelcomePageController::class, 'login'])->name('userin');
    Route::get('/user/register', [WelcomePageController::class, 'register'])->name('registeration');
	Route::get('/user/contactus',[WelcomePageController::class, 'getcontactform'])->name('contactus');

});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');;
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/user/leavereview',[ReviewController::class, 'postReview'])->name('postReview');
});

Route::middleware(['auth',AdminMiddleware::class])->group(function () {
    //get add product form to catalogue
    Route::get('/admin/add', [AdminController::class, 'addProduct'])->name('addProduct');
    //save product
    Route::post('/admin/store', [AdminController::class, 'storeproduct'])->name('storeproduct');
    //edit product
    Route::get('admin/product', [AdminController::class, 'Products'])->name('products');
    //update product
    Route::patch('admin/update', [AdminController::class, 'update'])->name('updateproduct');
    Route::delete('/catalogue/{id}', [AdminController::class, 'destroy'])->name('deleteproduct');
    Route::post('/catalogue/catalogueadmin/search', [AdminController::class, 'search'])->name('searchproducts');
    Route::get('/search-games', [AdminController::class, 'searchGames']);
    //dropprice fecther
    Route::get('/editsales/getprice', [AdminController::class, 'getprices'])->name('getprices');
    //add product to sale
    Route::post('/editsales/addtosales', [AdminController::class, 'addtosales'])->name('addtosales');
    //admin Sales page
    Route::get('/admin/sales', [AdminController::class, 'editsales'])->name('sales');
});

require __DIR__ . '/auth.php';
