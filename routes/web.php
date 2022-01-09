<?php
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\DefaultController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

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
//
//Route::get('/', function () {
//    return view('welcome');
//});

Route::namespace('Frontend')->group(function () {
    Route::get('/',[\App\Http\Controllers\Frontend\DefaultController::class,'index'])->name('home.Index');
    //Blog
    Route::get('/blog',[\App\Http\Controllers\Frontend\BlogController::class,'index'])->name('blog.Index');
    Route::get('/blog/{slug}',[\App\Http\Controllers\Frontend\BlogController::class,'detail'])->name('blog.detail');

    //Page
    Route::get('/page/{slug}',[\App\Http\Controllers\Frontend\PageController::class,'detail'])->name('page.detail');

    //Contact
    Route::get('/contact',[\App\Http\Controllers\Frontend\DefaultController::class,'contact'])->name('contact.detail');

});

Route::namespace('Backend')->group(function (){
    Route::prefix('nedmin')->group(function (){
        Route::get('/dashboard',[DefaultController::class,'index'])->name('nedmin.index')->middleware('admin');
        Route::get('/',[DefaultController::class,'login'])->name('nedmin.Login')->middleware('CheckLogin');
        Route::get('/logout',[DefaultController::class,'logout'])->name('nedmin.Logout');
        Route::post('/login',[DefaultController::class,'authenticate'])->name('nedmin.Authenticate');
    });



    Route::middleware(['admin'])->group(function (){
    Route::prefix('nedmin/settings')->group(function (){
        Route::get('/',[SettingsController::class,'index'])->name('settings.index');
        Route::post('',[SettingsController::class,'sortable'])->name('settings.sortable');
        Route::get('/delete/{id}',[SettingsController::class,'destroy'])->name('settings.destroy');
        Route::get('/edit/{id}',[SettingsController::class,'edit'])->name('settings.edit');
        Route::post('/{id}',[SettingsController::class,'update'])->name('settings.update');
    });
    });
});


    Route::prefix('nedmin')->group(function (){
        Route::middleware(['admin'])->group(function (){

            //Blog
        Route::post('/blog/sortable',[BlogController::class,'sortable'])->name('blog.sortable');
        Route::resource('blog',BlogController::class);

        //Page
        Route::post('/page/sortable',[PageController::class,'sortable'])->name('page.sortable');
        Route::resource('page',PageController::class);

        //Slider
        Route::post('/slider/sortable',[SliderController::class,'sortable'])->name('slider.sortable');
        Route::resource('slider',SliderController::class);


        //Admin
        Route::post('/user/sortable',[UserController::class,'sortable'])->name('user.sortable');
        Route::resource('user',UserController::class);

    });
    });


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
