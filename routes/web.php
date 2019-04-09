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

Route::get('/settings/user', 'Settings\SettingsUserController@show')->name('settings_user');
Route::patch('settings/user','Settings\SettingsUserController@update')->name('settings_user_update');

Route::get('/settings/cloudflare', 'Settings\SettingsCloudflareController@show')->name('settings_cloudflare');
Route::patch('settings/cloudflare','Settings\SettingsCloudflareController@update')->name('settings_cloudflare_update');

Route::get('/user/password', 'Settings\PasswordController@show')->name('password_show');
Route::patch('/user/password', 'Settings\PasswordController@update')->name('password_update');