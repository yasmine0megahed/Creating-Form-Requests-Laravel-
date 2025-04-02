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


Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);



Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('tasks', TaskController::class);


    Route::post('logout', [UserController::class, 'logout']);
});




Route::get('task/{id}/user', [TaskController::class, 'getTaskUser']);

Route::prefix('tasks')->group(function () {
    Route::post('/{taskid}/categories', [TaskController::class, 'addCategoryToTask']);
    Route::get('/{taskid}/categories', [TaskController::class, 'getTaskCategory']);
});


Route::apiResource('profiles', ProfileController::class);

Route::apiResource('categories', CategoryController::class);

Route::get('user/{id}/profile', [UserController::class, 'getProfile']);

Route::get('user/{id}/tasks', [UserController::class, 'getTasks']);


Route::get('task/all', [TaskController::class, 'getAllTasks'])->middleware('CheckUser', 'auth:sanctum');

