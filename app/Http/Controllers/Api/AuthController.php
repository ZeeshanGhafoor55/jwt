<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use DB;

class AuthController extends Controller
{
    

    public function register(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:10',
        ]);

        // Return errors if validation error occur.
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'error' => $errors
            ], 400);
        }

        // Check if validation pass then create user and auth token. Return the auth token
        if ($validator->passes()) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $token = $user->createToken('auth_token')->plainTextToken;
        
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                
            ]);
        }
    }



    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user'=>$user,
        ]);
    }

        public function logout(Request $request)
        {
            

            $user = User::where('email', $request['email'])->firstOrFail();


            DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->delete();
        // auth()->user()->currentAccessToken()->delete();
            //$request->user()->currentAccessToken()->delete();
            return response()->json([
                "success"=>true,
                "message"=>"logged out successfullly",
            ]);
        }

        public function users()
        {
            $user = User::all();
            return response()->json([
                "success"=>true,
                "users"=>$user,
            ]);
        }


}
