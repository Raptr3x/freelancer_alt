<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $resp = ['users' => DB::table('users')->select('name', 'profile_description', 'profile_picture')->get()];
        } catch (\Exception $e) {
            $resp = [
                'error' => 'An error occurred while fetching users',
                'message' => $e->getMessage()
            ];
        }

        return response()->json($resp);

    }

    /**
     * Display the specified user.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        try {
            $resp = ['user' => DB::table('users')->where('id', $user_id)->first()];
            if($resp['user'] == null) {
                $resp = ['error' => 'User ' . $user_id . ' not found'];
            }
        } catch (\Exception $e) {
            $resp = [
                'error' => 'An error occurred while fetching user ' . $user_id,
                'message' => $e->getMessage()
            ];
        }

        return response()->json($resp);
    }

    /**
     * Store a newly created user in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $user = [
                'name' => $request->name,
                'email' => $request->email,
                'contact_email' => $request->contact_email,
                'phone_number' => $request->phone_number,
                'password' => bcrypt($request->password),
                'profile_description' => $request->profile_description,
                'profile_picture' => $request->profile_picture
            ];

            if (DB::table('users')->where('email', $user['email'])->exists()) {
                $resp = ['error' => 'Email already in use'];
            } else {
                if (DB::table('users')->insert($user)) {
                    $resp = [
                        'message' => 'User created successfully',
                        'user_id' => DB::getPdo()->lastInsertId()
                    ];
                } else {
                    $resp = ['error' => 'Failed to create user'];
                }
            }

        } catch (\Exception $e) {
            $resp = [
                'error' => 'An error occurred while creating user',
                'message' => $e->getMessage()
            ];
        }

        return response()->json($resp);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'contact_email' => $request->contact_email,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
            'profile_description' => $request->profile_description,
            'profile_picture' => $request->profile_picture
        ];

        if(DB::table('users')->where('id', $request->user_id)->update($user)){
            $resp = [
                'message' => 'User ' . $request->user_id . ' updated successfully'
            ];
        } else {
            $resp = [
                'error' => 'Failed to update user ' . $request->user_id
            ];
        }

        return response()->json($resp);
    }

    /**
     * Delete the specified user from storage.
     *
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        if(DB::table('users')->where('id', $user_id)->delete()){
            $resp = [
                'message' => 'User ' . $user_id . ' deleted successfully'
            ];
        } else {
            $resp = [
                'error' => 'Failed to delete user ' . $user_id
            ];
        }

        return response()->json($resp);
    }
}
