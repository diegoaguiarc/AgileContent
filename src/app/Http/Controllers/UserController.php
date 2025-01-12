<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'users' => UserResource::collection(User::where('is_active', true)->get()),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validation
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required',
            'password' => 'required',
            'country' => 'required|numeric',
        ]);

        //Get country
        $country = Country::find($request->country);

        //Create User
        $newUser = new User();

        $newUser->name = $request->name;
        $newUser->email = $request->email;
        $newUser->password = $request->password;
        $newUser->country()->associate($country);
        $newUser->is_active = true;

        $newUser->save();

        // return new UserResource($newUser);
        return response()->json(
            [
                'user' => new UserResource($newUser),
            ],
            201
        );

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $userResource = new UserResource(User::findOrFail($user->id));

        $userData = $userResource->toArray(request());

        return response()->json([
            'user' => $userData,
        ], (empty($userData) ? 404 : 200));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $request->validate([
            'country' => 'numeric',
        ]);


        if ($request->filled('name')) {
            $user->name =  $request->name;
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        if ($request->filled('country') && $request->country != $user->country_id) {
            $country = Country::find($request->country);
            $user->country()->associate($country);
        }

        $user->update();

        return response()->json(
            [
                'user' => new UserResource($user),
            ],
            200
        );


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->update(['is_active' => false]);
        return response()->noContent(); //204 No Content
    }
}
