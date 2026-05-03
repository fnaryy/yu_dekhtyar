<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'show'])->name('home');

// 5 submissions per minute per IP — enough for honest users, blocks bots.
Route::post('/lead', [LeadController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('lead.store');
