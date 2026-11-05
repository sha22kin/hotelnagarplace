<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Welcome\WelcomeController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\MenusController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RoomsController;
use App\Http\Controllers\Admin\HotelItemsController;

Route::get('/',[WelcomeController::class,'index'])->name('index');
Route::redirect('/home-page', '/', 301)->name('homepage');

Route::get('/image/{template?}/{image?}',[WelcomeController::class,'imageView2'])->name('imageView2');
Route::get('/sitemap.xml',[WelcomeController::class,'siteMapXml'])->name('siteMapXml');
Route::post('/contact-mail',[WelcomeController::class,'contactMail'])->name('contactMail')->middleware('throttle:forms');
Route::post('/subscribe',[WelcomeController::class,'subscribe'])->name('subscribe')->middleware('throttle:forms');

Route::get('/geo/filter/{id}',[WelcomeController::class,'geo_filter'])->name('geo_filter');

Route::get('/blog/category/{slug}',[WelcomeController::class,'blogCategory'])->name('blogCategory');
Route::get('/blog/author/{id}/{slug}',[WelcomeController::class,'blogAuthor'])->name('blogAuthor');
Route::get('/blog/tag/{slug}',[WelcomeController::class,'blogTag'])->name('blogTag');
Route::get('/blog/search',[WelcomeController::class,'blogSearch'])->name('blogSearch');
Route::get('/blog/{slug}',[WelcomeController::class,'blogView'])->name('blogView');

Route::post('/blog-comments/{id}',[WelcomeController::class,'blogComments'])->name('blogComments')->middleware('throttle:forms');

//Auth Route Start

Route::any('/admin-login',[AuthController::class,'admin'])->name('admin')->middleware('throttle:auth');
Route::any('/login',[AuthController::class,'login'])->name('login')->middleware('throttle:auth');
Route::any('/forgot-password',[AuthController::class,'forgotPassword'])->name('forgotPassword')->middleware('throttle:auth');
Route::any('/reset-password/{token}',[AuthController::class,'resetPassword'])->name('resetPassword')->middleware('throttle:auth');
Route::post('/reset-password-check',[AuthController::class,'resetPasswordCheck'])->name('resetPasswordCheck')->middleware('throttle:auth');
Route::any('/register',[AuthController::class,'register'])->name('register')->middleware('throttle:auth');
Route::post('/log-out',[AuthController::class,'logout'])->name('logout');

Route::get('/{slug}',[WelcomeController::class,'pageView'])->name('pageView');

//Customer Route Group Start

Route::group(['prefix'=>'customer', 'as'=>'customer.','middleware'=>['auth','role:customer']], function(){

Route::get('/dashboard',[CustomerController::class,'dashboard'])->name('dashboard');

Route::any('/profile',[CustomerController::class,'profile'])->name('profile');
Route::any('/change-password',[CustomerController::class,'changePassword'])->name('changePassword');

});

// Admin Route Group Start

Route::group(['prefix'=>'admin', 'as'=>'admin.','middleware'=>['auth','role:admin','permission']], function(){

Route::get('/dashboard',[AdminController::class,'dashboard'])->name('dashboard');
Route::any('/my-profile',[AdminController::class,'myProfile'])->name('myProfile');

// Medias Library Route
Route::get('/medias',[AdminController::class,'medies'])->name('medies');
Route::post('/medias/create',[AdminController::class,'mediesCreate'])->name('mediesCreate');
Route::match(['get','post'],'/medias/edit/{id}',[AdminController::class,'mediesEdit'])->name('mediesEdit');
Route::get('/medies/delete/{id}',[AdminController::class,'mediesDelete'])->name('mediesDelete');
// Medias Library Route End

//Page Management
Route::get('/pages',[AdminController::class,'pages'])->name('pages');
Route::any('/pages/{action}/{id?}',[AdminController::class,'pagesAction'])->name('pagesAction');
//Page Management End

// Hotel Rooms (shown on the page with template "Rooms")
Route::get('/rooms',[RoomsController::class,'rooms'])->name('rooms');
Route::any('/rooms/{action}/{id?}',[RoomsController::class,'roomsAction'])->name('roomsAction');
// Hotel Rooms End

// Hotel Services & Packages (shown on the page with template "Services")
Route::get('/hotel-services',[HotelItemsController::class,'services'])->name('hotelServices');
Route::any('/hotel-services/{action}/{id?}',[HotelItemsController::class,'servicesAction'])->name('hotelServicesAction');
Route::get('/packages',[HotelItemsController::class,'packages'])->name('packages');
Route::any('/packages/{action}/{id?}',[HotelItemsController::class,'packagesAction'])->name('packagesAction');
// Hotel Services & Packages End

// Posts Comments Route End
Route::get('/posts/comments/all',[PostsController::class,'postsCommentsAll'])->name('postsCommentsAll');
Route::get('/posts/comments/post/{id}',[PostsController::class,'postsComments'])->name('postsComments');
Route::any('/posts/comments/{action}/{id}',[PostsController::class,'postsCommentsAction'])->name('postsCommentsAction');
// Posts Comments Route End

// Posts Categories Route
Route::get('/posts/categories',[PostsController::class,'postsCategories'])->name('postsCategories');
Route::any('/posts/categories/{action}/{id?}',[PostsController::class,'postsCategoriesAction'])->name('postsCategoriesAction');
// Posts Categories Route End

// Posts Tags Route
Route::get('/posts/tags',[PostsController::class,'postsTags'])->name('postsTags');
Route::any('/posts/tags/{action}/{id?}',[PostsController::class,'postsTagsAction'])->name('postsTagsAction');
// Posts Tags Route End

// Posts Route
Route::get('/posts',[PostsController::class,'posts'])->name('posts');
Route::any('/posts/{action}/{id?}',[PostsController::class,'postsAction'])->name('postsAction');
// Posts Route End

// Clients Route
Route::get('/clients',[AdminController::class,'clients'])->name('clients');
Route::any('/clients/{action}/{id?}',[AdminController::class,'clientsAction'])->name('clientsAction');
// Clients Route End

// Slider Route
Route::get('/sliders',[AdminController::class,'sliders'])->name('sliders');
Route::any('/sliders/{action}/{id?}',[AdminController::class,'slidersAction'])->name('slidersAction');
Route::any('/sliders/slide/{action}/{id}',[AdminController::class,'slideAction'])->name('slideAction');
// Slider Route End

// Gallery Route
Route::get('/galleries',[AdminController::class,'galleries'])->name('galleries');
Route::any('/galleries/{action}/{id?}',[AdminController::class,'galleriesAction'])->name('galleriesAction');
// Gallery Route End

// Theme Route
Route::get('/theme-setting',[AdminController::class,'themeSetting'])->name('themeSetting');
Route::any('/theme-setting/{action}/{id?}',[AdminController::class,'themeSettingAction'])->name('themeSettingAction');
// Theme Route End

// Menus Route
Route::get('/menus',[MenusController::class,'menus'])->name('menus');
Route::any('/menus/config/{action}/{id?}',[MenusController::class,'menusAction'])->name('menusAction');
Route::post('/menus/items/post/{id}',[MenusController::class,'menusItemsPost'])->name('menusItemsPost');
Route::any('/menus/items/{action}/{id}',[MenusController::class,'menusItemsAction'])->name('menusItemsAction');
// Menus Route End

//User Management
Route::get('/users/admin/',[AdminController::class,'usersAdmin'])->name('usersAdmin');
Route::any('/users/admin/{action}/{id?}',[AdminController::class,'usersAdminAction'])->name('usersAdminAction');

Route::get('/users/customer/',[AdminController::class,'usersCustomer'])->name('usersCustomer');
Route::any('/users/customer/{action}/{id?}',[AdminController::class,'usersCustomerAction'])->name('usersCustomerAction');

Route::get('/users/roles',[AdminController::class,'userRoles'])->name('userRoles');
Route::any('/users/roles/{action}/{id?}',[AdminController::class,'userRoleAction'])->name('userRoleAction');

Route::get('/subscribes',[AdminController::class,'subscribes'])->name('subscribes');

// Apps Setting
Route::get('/setting/{type}',[AdminController::class,'setting'])->name('setting');
Route::post('/setting/{type}/update',[AdminController::class,'settingUpdate'])->name('settingUpdate');

});