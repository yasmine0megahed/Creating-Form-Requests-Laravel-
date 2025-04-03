<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $tasks = Auth::user()->tasks;
        return response()->json(
            $tasks,
            200
        );
    }
    public function getTasksByPeriority()
    {
        $tasks = Auth::user()->tasks()->orderByRaw('FIELD(priority, "high", "medium", "low")')->get();
        return response()->json(
            $tasks,
            200
        );
    }
    public function getAllTasks()
    {
        $tasks = Task::all();
        return response()->json(
            $tasks,
            200
        );
    }
    public function store(StoreTaskRequest $request)
    {
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user_id;
        $task = Task::create($validatedData);
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
        $user_id = Auth::user()->id;
        $task = Task::findOrFail($id);
        if ($task->user_id != $user_id) {
            return response()->json([
                "message" => "You do not have permission to update this task."
            ], 403);
        }
        $task->update($request->validated());
        return response()->json(
            $task,
            200
        );
    }
    public function destroy($id)
    {
        try {
            $user_id = Auth::user()->id;
            $task = Task::findOrFail($id);
            if ($task->user_id != $user_id) {
                return response()->json([
                    "message" => "You do not have permission to delete this task."
                ], 403);
            }
            $task->delete();
            return response()->json(
                [
                    "message" => "Task deleted successfully"
                ],
                200
            );
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "message" => "Task not found",
                "error" => $e->getMessage()
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                "message" => "some thing went wrong",
                "error" => $e->getMessage()
            ], 404);
        }
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

    public function addToFavorites($taskId)
    {
        Task::findOrFail($taskId);
        Auth::user()->favoraiteTasks()->syncWithoutDetaching($taskId);
        return response()->json(
            [
                "message" => "Task added to favorites"
            ],
            200
        );
    }
    public function removeFavorites($taskId)
    {
        Task::findOrFail($taskId);
        Auth::user()->favoraiteTasks()->detach($taskId);
        return response()->json(
            [
                "message" => "Task REMOVED to favorites"
            ],
            200
        );
    }
}
