<?php

use App\Http\Controllers\RowController;
use App\Http\Middleware\authBasic;
use Illuminate\Support\Facades\Route;

Route::get('/rows', [RowController::class, 'getRows']);
Route::group(['middleware' => [authBasic::class]], function () {
    Route::get('/upload', [RowController::class, 'showUploadForm']);
    Route::post('/upload', [RowController::class, 'parseExcel'])->name('parse.excel');
});
