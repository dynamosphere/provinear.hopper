<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{

     /**
     * Register a new user.
     *
     * @param Request $request The incoming request.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response containing the user data.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName'      => 'required|string|max:255',
            'lastName'      => 'required|string|max:255',
            'email'     => 'required|email|string|max:255|unique:users',
            'password'  => 'required|string|min:7'
          ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = User::create([
            'first_name'      => $request->firstName,
            'last_name'      => $request->lastName,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);
        event(new Registered($user));
        Auth::login($user);
        $token = $user->createToken($request->token_name ?: 'auth_token')->plainTextToken;
        return response()->json([
            'data'          => $user,
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    /**
     * Log in a user.
     *
     * @param Request $request The incoming request.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response containing the authentication token.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email|string|max:255',
            'password'  => 'required|string'
          ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $credentials = $request->only(['email', 'password']);
        if (!Auth::attempt($credentials)){
            return response()->json([
                "message" => "User does not exist"
            ], 401);
        }

        $user   = User::where('email', $request->email)->firstOrFail();
        $token  = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message'       => 'Login success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);

    }

    /**
     * Get the authenticated user.
     *
     * @param Request $request The incoming request.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response containing the authenticated user.
     */
    public function user(Request $request)
    {
        return response()->json([
            "user" => $request->user()
        ]);
    }

    /**
     * Log out the authenticated user.
     *
     * @param Request $request The incoming request.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response containing the logout message.
     */
    public function logout(Request $request)
    {
        $request->user->tokens()->delete();

        return response()->json([
            "message" => "Logout successful"
        ]);
    }
}
