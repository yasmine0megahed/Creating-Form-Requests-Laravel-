<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\updateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function index()
    {
        //
    }


    public function store(StoreProfileRequest $request)
    {
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user_id;
        if($request->hasFile('image')){
            $path=$request->file('image')->store('my_image','public');
            $validatedData['image']=$path;
        }
        $Profile = Profile::create($validatedData);
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
