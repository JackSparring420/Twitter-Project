<?php

use Atymic\Twitter\Facade\Twitter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Coderjerk\BirdElephant\BirdElephant;

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
//     return view('pages.my-tweets');
// });


// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');


// homepage
// Route::get('/', 'TwitterController@home')->name('home');

// profile
Route::get('/', 'TwitterController@profile')->name('profile');

// get tweets on my DB
Route::get('/MyTweets', 'TwitterController@MyTweets');
// new tweet
Route::post('/create', 'TwitterController@create')->name('create');
Route::post('/createVue', 'TwitterController@createVue');
// delete tweet
Route::post('/delete/{id}', 'TwitterController@delete');

//post tweet
Route::get('/postTweet', 'TwitterController@postTweet');