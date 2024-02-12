<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Auth::routes();
Route::get('/', function () {
    return Redirect::route('admin.login');
});

Route::get('/login', function () {
    return Redirect::route('admin.login');
})->name('login');

Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->group(function () {
    Route::get('/login', 'AdminController@login')->name('admin.login');
    Route::post('/login', 'AdminController@login')->name('admin.login');
    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
        Route::get('/import-video', 'VideoController@ImportVideo')->name('admin.import.video');
        Route::post('/import-video', 'VideoController@ImportVideo')->name('admin.import.video');
        Route::get('/category', 'VideoController@Category')->name('admin.category');
        Route::get('category/update/order', 'VideoController@UpdateCategoryOrder')->name('admin.update-order');
        Route::match(['get', 'post'], '/add-category', 'VideoController@AddCategory')->name('admin.category.add');
        Route::post('/admin/category/update/{id}', 'VideoController@UpdateCategory')->name('admin.category.update');
        Route::get('/category/edit/{id}', 'VideoController@EditCategory')->name('admin.category.edit');
        Route::get('/delete/category/{category_id?}', 'VideoController@DeleteCategory')->name('admin.category.delete');
        Route::match(['get', 'post'], '/reset/data', 'AdminController@ResetData')->name('admin.reset.data');
        Route::get('/admin/videos', 'VideoController@index')->name('admin.videos');



        Route::get('/logout', 'AdminController@logout')->name('admin.logout');
    });
});
