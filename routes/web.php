<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\PayController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
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

Route::get('/',[HomeController::class,'index']);

Route::get('/profile',[HomeController::class,'profile']);
Route::get('/profile/logout',[HomeController::class,'logout']);

Route::get('/registration',[RegistrationController::class,'index']);
Route::get("/registration/auth/redirect/google",[RegistrationController::class,"continueWithGoogle"]);
Route::get("/registration/auth/redirect/git",[RegistrationController::class,"continueWithGitHub"]);
Route::get("/auth/git/callback",[RegistrationController::class,"registartionOrLoginWithGitHub"]);
Route::get("/auth/google/callback",[RegistrationController::class,"registartionOrLoginWithGoogle"]);
Route::post('/rg',[RegistrationController::class,'registrate']);

Route::get('/login',[LoginController::class,'index']);
Route::post('/lg',[LoginController::class,'defaultLogin']);

Route::get('/films',[MoviesController::class,'index']);

Route::get('/films/adminAddMovie',[MoviesController::class,'addMovie_Index']);
Route::post('/films/adminAddMovie/addM',[MoviesController::class,'saveMovie']);
Route::get('/films/adminAddSession',[MoviesController::class,'addSession_Index']);
Route::post('/films/adminAddMovie/addS',[MoviesController::class,'saveSession']);
Route::get('/films/adminSeeUsers',[MoviesController::class,'seeUsers_Index']);
Route::get('/films/{movieID}',[MoviesController::class,'selectedFilm']);
Route::get('/films/{movieID}/tickets',[MoviesController::class,'tickets']);
Route::get('/films/{movieID}/edit',[MoviesController::class,'edit_index']);
Route::get('/films/adminSeeUsers/{userID}',[MoviesController::class,'permisions_controller']);
Route::post('/films/{movieID}/edit/save',[MoviesController::class,'edit_saveChanges']);
Route::post('/films/{movieID}/comment',[MoviesController::class,'comment']);

Route::get('/films/{movieID}/pay/{sessionID}',[PayController::class,'index']);
Route::post('/films/{movieID}/pay/{sessionID}/checkData',[PayController::class,'checkData']);
Route::get('/films/{movieID}/pay/{sessionID}/{countTickets}/credentials',[PayController::class,'credentials']);
Route::post('/films/{movieID}/pay/{sessionID}/complate',[PayController::class,'pay']);




