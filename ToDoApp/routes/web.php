<?php

use App\Http\Controllers\TaskController;
Route::resource('tasks', TaskController::class);
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
