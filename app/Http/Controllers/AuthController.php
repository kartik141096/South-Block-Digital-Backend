<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // USER REGISTRATION
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['user' => $user]);
    }

    // USER LOGIN
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        // dd(bcrypt($request->password));
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->accessToken;
            return response()->json(['user' => $user, 'access_token' => ['name'=>$token['name'], 'token'=>$token['token'], 'expires_at' => $token['expires_at'], 'created_at' => $token['created_at']]]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // FORGOT PASSWORD
    public function forgotpassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'current_password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }


        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password changed successfully']);
    }

    public function is_loged_in(Request $request)
    {
        dd(Auth::user());
        if (Auth::check()) {
            // User is logged in
            // You can access the authenticated user using Auth::user()
            $user = Auth::user();
            dd($user);

            // Perform actions for authenticated users
        } else {
            dd("kkkkkkkkkkk");
            // User is not logged in
            // Perform actions for unauthenticated users
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

}
