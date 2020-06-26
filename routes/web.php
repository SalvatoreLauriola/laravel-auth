<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('guest.welcome');
})->name('home');



Auth::routes();

//Guest
Route::get('posts', 'PostController@index')->name('posts.index');


//ADMIN protetto
Route::prefix('admin')
    ->name('admin.')  //aggiunge il prefisso admin nella rotta
    ->namespace('Admin')  //dove trovare controller nella rotta
    ->middleware('auth') //proteggiamo
    ->group(function() {
        Route::get('/home', 'HomeController@index')->name('home');
        Route::resource('posts', 'PostController');

    });



