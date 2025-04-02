<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return response()->json([
            'message' => 'user created successfully',
            'user' => $user
        ], 201);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'invalid credentials'], 401);
        }
        $user=User::where('email','=',$request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
        'message' => 'success', 
        'access_token' => $token, 
        'token_type' => 'Bearer',
        'user' => $user], 200);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'success'], 200);
    }





    public function getProfile($id)
    {
        $profile = User::find($id)->profile;
        return response()->json(
            $profile,
            200
        );
    }
    public function getTasks($id)
    {
        $tasks = User::findOrFail($id)->tasks;
        return response()->json(
            $tasks,
            200
        );
    }
}
