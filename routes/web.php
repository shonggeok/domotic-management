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

Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');

Route::get('/user/password', 'Settings\PasswordController@show')->name('password_show');
Route::patch('/user/password', 'Settings\PasswordController@update')->name('password_update');
