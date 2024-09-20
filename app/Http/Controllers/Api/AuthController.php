<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55|min:3',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric',
            'password' => 'required',
            'profile_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profilePhotoPath = null;
        if ($request->hasFile('profile_photo')) {
            $profilePhotoPath = Storage::disk('public')->putFile('profile_photos', $request->file('profile_photo'));
        }

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']),
            'roles' => 'user',
            'profile_photo' => $profilePhotoPath,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => UserResource::make($user),
        ]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        $user = User::where(
            'email',
            $loginData['email']
        )->first();

        if (!$user)
        {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }

        if (!Hash::check($loginData['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Membuat Token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => UserResource::make($user),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout success',
        ]);
    }
}
