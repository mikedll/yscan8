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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('videos', 'VideoController')->only(['store']);

Route::get('/videos', function () {
    $videos = App\Video::orderBy('score', 'desc')->get();
    return view('videos', ['videos' => $videos]);
});
