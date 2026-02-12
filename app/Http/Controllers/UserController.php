<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('userType', 'person')->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'user_type_id' => 'nullable|exists:user_type,id',
            'user_type' => 'nullable|string',
        ]);

        // If user_type string is provided, find the user_type_id
        if (isset($validated['user_type']) && !isset($validated['user_type_id'])) {
            $userType = \App\Models\UserType::where('type', $validated['user_type'])->first();
            if ($userType) {
                $validated['user_type_id'] = $userType->id;
            }
            unset($validated['user_type']);
        }

        // Default to user_type_id = 2 (coach) if not provided
        if (!isset($validated['user_type_id'])) {
            $validated['user_type_id'] = 2;
        }

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        $user->load('userType', 'person');
        
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            'id' => $user->id  // Explicitly return ID at root level
        ], 201);
    }

    public function show(User $user)
    {
        $user->load('userType', 'person');
        return response()->json($user);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'user_type_id' => 'exists:user_type,id',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);
        $user->load('userType', 'person');
        
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        
        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }
}
