<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/profile', [\App\Http\Controllers\PostController::class, 'allPosts'])
    ->middleware('auth')->name('profile');
Route::get('/user/{username}', [\App\Http\Controllers\ProfileController::class, 'getProfile'])
    ->name('profile.index');

/* Сообщения */

Route::post('/profile/add-message', [\App\Http\Controllers\ProfileController::class, 'sendMessage'])
    ->middleware('auth')->name('sendMessage');
Route::get('/messages', [\App\Http\Controllers\ProfileController::class, 'getMessages'])
    ->middleware('auth')->name('messages');
Route::get('/update-msg', [\App\Http\Controllers\ProfileController::class, 'updateMessages'])
    ->middleware('auth')->name('update-msg');

/* Посты */

Route::get('/user/like/{id}', [\App\Http\Controllers\PostController::class, 'like'])
    ->middleware('auth')->name('like');
Route::get('/user/dislike/{id}', [\App\Http\Controllers\PostController::class, 'dislike'])
    ->middleware('auth')->name('dislike');

Route::post('/profile/add-post', [\App\Http\Controllers\PostController::class, 'addPost'])
    ->middleware('auth')->name('addPost');
Route::post('/profile/add-comment', [\App\Http\Controllers\PostController::class, 'addComment'])
    ->middleware('auth')->name('addComment');

/* Авторизация */

Route::get('/signup', [\App\Http\Controllers\AuthController::class, 'getSignup'])
    ->middleware('guest')->name('auth.signup');
Route::post('/signup', [\App\Http\Controllers\AuthController::class, 'postSignup'])
    ->middleware('guest');

Route::get('/signin', [\App\Http\Controllers\AuthController::class, 'getSignin'])
    ->middleware('guest')->name('auth.signin');
Route::post('/signin', [\App\Http\Controllers\AuthController::class, 'postSignin'])
    ->middleware('guest');

Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])
    ->middleware('auth')->name('auth.logout');