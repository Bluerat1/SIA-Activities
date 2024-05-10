<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


 
Route::get('/register', [UserController::class, 'showRegistrationForm']);


Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('post-registration', [UserController::class, 'postRegistration'])->name('register.post'); 

Route::get('/login', [UserController::class, 'showLoginForm']);

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('post-login', [UserController::class, 'postLogin'])->name('login.post'); 



Route::get('dashboard', [UserController::class, 'dashboard']); 
Route::get('logout', [UserController::class, 'logout'])->name('logout');