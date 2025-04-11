<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/days', function () {
    return view('days');
});
Route::get('/404', function () {
    return view('404');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/contact', function () {
    return view('contact');
});
Route::get('/admin', function () {
    return view('admin');
});
Route::get('/centre', function () {
    return view('centre');
});
Route::get('/donneur', function () {
    return view('donneur');
});
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/logout', function () {
    return view('logout');
});
Route::get('/profile', function () {
    return view('profile');
});
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/home', function () {
    return view('home');
});
