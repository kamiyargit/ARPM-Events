<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiCalendarControler;


Route::middleware('api')->group(function () {

    Route::get('calendar/all', [ApiCalendarControler::class, 'getAll'])->middleware(['auth:sanctum']);
    Route::post('calendar/store', [ApiCalendarControler::class, 'store'])->middleware(['auth:sanctum']);
    Route::post('calendar/update', [ApiCalendarControler::class, 'update'])->middleware(['auth:sanctum']);
    Route::post('calendar/delete', [ApiCalendarControler::class, 'destroy'])->middleware(['auth:sanctum']);

    
});
