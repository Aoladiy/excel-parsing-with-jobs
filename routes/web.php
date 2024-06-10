<?php

use App\Http\Middleware\authBasic;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware([authBasic::class]);
