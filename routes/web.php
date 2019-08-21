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

/**
 * Route untuk menampilkan beranda perkim
 */
Route::get('/', 'HomeController@index')->name('login');

Auth::routes();
//TODO : Tambahkan method get untuk logout

//Route untuk beranda
Route::get('/home', 'HomeController@index')->name('home');

// Route untuk user 
Route::resource("users", "UserController");

// Route untuk manajemen kategori menu
Route::get('/categories/trash', 'CategoryMenuController@trash')->name('categories.trash'); //Route Trash
Route::post('/categories/{id}/restore', 'CategoryMenuController@restore')->name('categories.restore'); //Route Restore
Route::delete('/categories/{id}/delete-permanent', 'CategoryMenuController@deletePermanent')->name('categories.delete-permanent'); //Route Delete Permanent
Route::resource('categories', 'CategoryMenuController');

//Route untuk manajemen daftar sub menu 
Route::get('/submenus/trash', 'SubmenuController@trash')->name('submenus.trash'); //Route Trash
Route::post('/submenus/{id}/restore', 'SubmenuController@restore')->name('submenus.restore'); //Route Restore
Route::delete('/submenus/{id}/delete-permanent', 'SubmenuController@deletePermanent')->name('submenus.delete-permanent');
Route::resource('submenus', 'SubmenuController');

//Route untuk berita/news 
Route::get('/news/trash', 'NewsController@trash')->name('news.trash'); //Route Trash
Route::post('/news/{id}/restore', 'NewsController@restore')->name('news.restore'); //Route Restore
Route::delete('/news/{id}/delete-permanent', 'NewsController@deletePermanent')->name('news.delete-permanent');
Route::resource('news', 'NewsController');

//Route untuk foto banner
Route::get('/banners/trash', 'BannerController@trash')->name('banners.trash'); //Route Trash
Route::post('/banners/{id}/restore', 'BannerController@restore')->name('banners.restore'); //Route Restore
Route::delete('/banners/{id}/delete-permanent', 'BannerController@deletePermanent')->name('banners.delete-permanent');
Route::resource('banners', 'BannerController');