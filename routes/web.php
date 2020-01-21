<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', 'LoginController@index')->name('login');
Route::post('/', 'LoginController@auth')->name('auth');
Route::get('/logout', 'LoginController@logout')->name('logout');


Route::resource('/produksi', 'ProduksiController');
Route::get('/screen/loadData', 'ScreenController@loadData')->name('screen.loaddata');
Route::get('/screen/rtData', 'ScreenController@realTime')->name('screen.realtime');
Route::get('/screen/rt', 'ScreenController@GetRtView');
Route::get('/screen', 'ScreenController@index');

Route::resource('/admin/user', 'UserController');

Route::post('/packing/store', 'PackingController@store')->name('packing.store');
Route::get('/packing', 'PackingController@index')->name('packing.index');

Route::post('/oven/move_data_in', 'OvenController@MoveFromOven')->name('oven.move_from_oven');
Route::post('/oven/move_data_wait', 'OvenController@MoveToOven')->name('oven.move_to_oven');
Route::get('/oven/loadOut', 'OvenController@LoadDataOut')->name('oven.LoadOut');
Route::get('/oven/loadIn', 'OvenController@LoadDataIn')->name('oven.LoadIn');
Route::get('/oven/loadTunggu', 'OvenController@LoadDataTunggu')->name('oven.LoadTunggu');
Route::get('/oven', 'OvenController@index')->name('oven.index');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/preproduksi/simple', 'PreproduksiController@simpleView')->name('preproduksi.simpleView');
    Route::get('/preproduksi/{date}/{id}', 'PreproduksiController@showByItem')->name('preproduksiDateId');
    Route::get('/preproduksi/{date}', 'PreproduksiController@showByDate');
    Route::post('/preproduksi/simple', 'PreproduksiController@store');
    Route::resource('/preproduksi', 'PreproduksiController');
    Route::resource('/dashboard/gudang', 'GudangController');
    Route::get('/dashboard/dataStock', 'StockController@ajaxGetStock')->name('dataStock');
    Route::resource('/dashboard/stock', 'StockController');
    Route::resource('/dashboard/item', 'ItemController');
    Route::get('/dashboard/item-stock', 'HomeController@itemStock')->name('dashboard.item-stock');
    Route::resource('/dashboard', 'HomeController');
    Route::get('/admin/dashboard', 'AdminController@index')->name('admin.dashboard');
});

