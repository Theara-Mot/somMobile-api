<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{
    //register controller
    public function register(Request $request){
        try{
            $validateUser = Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'type' => 'required'
            ]);
    
            if($validateUser -> fails()){
                return response()->json([
                    'status' =>false,
                    'message' =>'validation error',
                    'error' => $validateUser->errors()
                ],401);
            }
    
            $user = User::create([
                'name' => $request -> name,
                'email' => $request -> email,
                'password' => $request -> password,
                'type' => $request -> type
            ]);
    
            return response()->json([
                'status' => true,
                'message' => 'User created successfully!',
                'name' => $user->name,
                'email' => $user->email,
                'type' => $user -> type,
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 201);

        }catch(\Throwable $th){
            return response()->json([
                'status' =>false,
                'message' => $th->getMessage(),
            ],500);
        }
    }

    // login controller
    public function login(Request $request){
        try{
            $validatedData = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        
            // Attempt to log the user in
            if (Auth::attempt($validatedData)) {
                // Authentication was successful
                $user = Auth::user();
        
                return response()->json([
                    'status' => true,
                    'message' => 'Login successful!',
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'type' => $user ->type
                    ],
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ], 200);
            } else {
                // Authentication failed
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials',
                ], 401);
            }
        }catch(\Throwable $th){
            return response()->json([
                'status' =>false,
                'message' => $th->getMessage(),
            ],500);
        }
    }

    // profile
    public function profile(Request $request){
        $user = Auth::user();
    
        return response()->json([
            'status' => true,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'type' => $user -> type
            ],
        ], 200);
    }

    // update profile
    public function updateProfile(Request $request){
        $user = Auth::user();
    
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8',
        ]);
    
        // Update the user's profile information
        if (isset($validatedData['name'])) {
            $user->name = $validatedData['name'];
        }
        if (isset($validatedData['email'])) {
            $user->email = $validatedData['email'];
        }
        if (isset($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }
    
        $user->save();
    
        return response()->json([
            'status' => true,
            'message' => 'Profile updated successfully!',
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
        ], 200);
    }

    public function logout(Request $request){
        Auth::user()->tokens()->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully!',
            
        ], 200);
    }
}

