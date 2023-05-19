<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
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
//Common Resource Routes:
// index - Show all listings
// show - Show a single listing
// create - show a form to create a new listing
// store - store a new listing
// edit - show a form to edit a listing
// update - update a listing
// destroy - delete a listing

Route::get('/', function () {
    return view('welcome');
});

//all listings
Route::get('/Listings', [ListingController::class, 'index']);

//Show create Form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

//store listing data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

//show edit form
Route::get('/listings/edit/{listing}', [ListingController::class, 'edit'])->middleware('auth');

//update listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'delete'])->middleware('auth');

//manage listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

//single listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

//show register/ create form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//create new user
Route::post('/users', [UserController::class, 'store']);

//Logout
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

Route::get('/hello', function () {
    return response('<h1>Hello dang</h1>', 200)
            ->header('Content-Type', 'text/plain')
            ->header('foo', 'bar');
});

// Show login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

//Login user routes
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

Route::get('/posts/{id}', function ($id) {
    //dd($id);
    //ddd($id);
    return response('Post ' . $id);
})->where('id', '[0-9]+');

Route::get('/search', function (Request $request) {
    return $request->name . ' ' . $request->city;
    //dd($request);
});
