<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json(
            $tasks,
            200
        );
    }
    public function store(StoreTaskRequest $request)
    {
        $task = Task::create($request->validated());
        return response()->json(
            $task,
            201
        );
    }
    public function show($id)
    {
        $task = Task::findOrFail($id);
        return response()->json(
            $task,
            200
        );
    }
    public function update(UpdateTaskRequest $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->validated());
        return response()->json(
            $task,
            200
        );
    }
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(
            null,
            204
        );
    }
    public function getTaskUser($id)
    {
        $user = Task::findOrFail($id)->user;
        $profile = Task::findOrFail($id)->user->profile;

        return response()->json(
            [
                'user' => $user,
                'profile' => $profile
            ],
            200
        );
    }
    public function addCategoryToTask($taskId, Request $request)
    {
        $task = Task::findOrFail($taskId);
        $task->categories()->attach($request->category_id);
        return response()->json(
            'category added successfully',
            200
        );
    }
    public function getTaskCategory($taskId)
    {
        $categories = Task::findOrFail($taskId)->categories;
        return response()->json(
            $categories,
            200
        );
    }
}
