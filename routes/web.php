<?php

use App\Http\Controllers\RowController;
use App\Http\Middleware\authBasic;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/rows', [RowController::class, 'getRows'])->name('rows');
Route::group(['middleware' => [authBasic::class]], function () {
    Route::get('/upload', [RowController::class, 'showUploadForm'])->name('upload');
    Route::post('/upload', [RowController::class, 'parseExcel'])->name('parse.excel');
});
