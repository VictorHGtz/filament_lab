<?php

use App\Http\Controllers\Api\GuestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/guests/{guestCode}', [GuestController::class, 'show']);
Route::post('/guests/{guestCode}/rsvp', [GuestController::class, 'rsvp']);
