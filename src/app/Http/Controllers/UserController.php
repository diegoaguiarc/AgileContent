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
        return UserResource::collection(User::where('is_active', true)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validation
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required',
            'password' => 'required',
            'country' => 'required|numeric',
        ]);

        if ($validated) {

            //Get country
            $country = Country::find($request->country);

            //Create User
            $newUser = new User();

            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->password = $request->password;
            $newUser->country()->associate($country);

            $newUser->save();

            return new UserResource($newUser);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource(User::findOrFail($user->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {

        $validated = $request->validate([
            'country' => 'numeric',
        ]);

        if ($validated) {

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

            return new UserResource($user);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->update(['is_active' => false]);
    }
}
