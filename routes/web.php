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

Route::get('/videos', function () {
    $videos = [
               "Vyt5uAFVCOc" => "Barbara the Snob",
               "dlkjoo890" => "Why Hillary Clinton wears black pants.",
               "lsd098" => "Making Baked Chicken.",
               ];
    return view('videos', ['videos' => $videos]);
});
