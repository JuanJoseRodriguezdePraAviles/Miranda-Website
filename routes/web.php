<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('activity', ActivityController::class);
Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
