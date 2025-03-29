<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// Route::get('index',[TaskController::class,'index']);
// Route::post('tasks',[TaskController::class,'store']);
// Route::get('task/{id}',[TaskController::class,'show']);
// Route::put('tasks/{id}',[TaskController::class,'update']);
// Route::delete('task/{id}/delete',[TaskController::class,'destroy']);

Route::apiResource('tasks', TaskController::class);