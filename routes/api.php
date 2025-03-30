<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Models\Task;
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
Route::get('task/{id}/user',[TaskController::class,'getTaskUser']);

Route::post('tasks/{taskid}/categories',[TaskController::class,'addCategoryToTask']);
Route::get('tasks/{taskid}/categories',[TaskController::class,'getTaskCategory']);

Route::apiResource('profiles', ProfileController::class);

Route::apiResource('categories', CategoryController::class);

Route::get('user/{id}/profile', [UserController::class, 'getProfile']);

Route::get('user/{id}/tasks',[UserController::class,'getTasks']);

