<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\updateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    public function index()
    {
        //
    }


    public function store(StoreProfileRequest $request)
    {
        $Profile = Profile::create($request->validated());
        return response()->json(
            [
                'message' => 'Profile created successfully',
                'data' => $Profile
            ],
            201
        );
    }


    public function show( $id)
    {
        $profile= Profile::where('user_id', $id)->firstOrFail();    
        return response()->json(
         $profile,200
        );
    }


    public function update(updateProfileRequest $request, $id)
    {
        //
    }

    public function destroy(Profile $profile)
    {
        //
    }
}
