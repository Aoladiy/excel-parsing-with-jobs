<?php

use App\Http\Controllers\RowController;
use Illuminate\Support\Facades\Route;

Route::get('/rows', [RowController::class, 'getRows']);
