<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = DB::table('users')->select('name', 'profile_description', 'profile_picture')->get();
            return response()->json([
                'users' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred while fetching users',
                'message' => $e->getMessage()
            ]);
        }

    }

    public function show($user_id)
    {
        // return a JSON response of a single user, their name, description, and image path
        return response()->json([
            'user' => [
                'id' => $user_id,
                'name' => 'John Doe',
                'description' => 'A software developer',
                'image' => 'https://via.placeholder.com/150'
            ]
        ]);
    }

    public function store(Request $request)
    {
        return response()->json([
            'message' => 'User created successfully'
        ]);
    }

    public function update(Request $request, $user_id)
    {
        return response()->json([
            'message' => 'User ' . $user_id . ' updated successfully'
        ]);
    }

    public function destroy($user_id)
    {
        return response()->json([
            'message' => 'User ' . $user_id . ' deleted successfully'
        ]);
    }
}
