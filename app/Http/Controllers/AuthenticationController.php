<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\Enums\TelegramMessageType;
use App\Notifications\TelegramNotification;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthenticationController extends Controller
{

     /**
     * @unauthenticated
     * Register a new user.
     *
     * @param Request $request The incoming request.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response containing the user data.
     */
    public function register(Request $request)
    {
        $request->validate([
            'firstName'      => 'required|string|max:255',
            'lastName'      => 'required|string|max:255',
            'email'     => 'required|email|string|max:255|unique:user',
            'password'  => 'required|string|min:7'
          ]);

        $user = User::create([
            'first_name'      => $request->firstName,
            'last_name'      => $request->lastName,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);
        event(new Registered($user));

        $user->notify(new TelegramNotification(TelegramMessageType::NEW_USER));

        Auth::login($user);
        $token = $user->createToken($request->token_name ?: 'auth_token')->plainTextToken;
        return response()->json([
            'data'          => $user,
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    /**
     * Verify the user's email address.
     * 
     * ⚠️ 
     * To verify an email.
     * 
     * The frontend have to provide a `/verify-email` route that accepts a `url` parameter
     * This is because the Provinear application sends all email verification links in the form
     * `https://frontendapplication.com/verify-email?url=https://backendapplication.com/api/email/verify/<id>/<hash>`
     * The frontend application should get this url and make a application/json `GET` request to it to verify the user's email.
     * Include Authorization token in your request
     * The url sent is encoded, so it needs to be decoded before been called
     * 
     * The frontend does not necessarily need not extract the `id` and `hash` from the url
     * to call this endpoint directly, rather, make a `GET` request to the url in its decoded entirety.
     * This is because the url has a signature.
     *
     * @param EmailVerificationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyEmail(EmailVerificationRequest $request) {
        
        if (! $request->user()->hasVerifiedEmail()) {
            $request->user()->markEmailAsVerified();

            event(new Verified($request->user()));
        }else{
            return response()->json([
                "message" => "Your email is verified already"
            ], 200);
        }
        return response()->json([
            "message" => "Email verified successfully"
        ], 202);
    }

    /**
     * Resend the verification email to the user.
     * 
     * Resend the verification email link to the user.
     * 
     * The Provinear application sends all email verification links in the form
     * `https://frontendapplication.com/verify-email?url=https://backendapplication.com/api/email/verify/<id>/<hash>`
     * The frontend application should get this url and make a `GET` request to it to verify the user's email.
     * The url is encoded, so it needs to be decoded before been called.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendVerificationEmail(Request $request) {
        if (!$request->user()->hasVerifiedEmail()){
            $request->user()->sendEmailVerificationNotification();
        
            return response()->json([
                "message" => "Email verification link sent successfully"
            ], 200);
        }
        return response()->json([
            "message" => "Your email is verified already"
        ], 200);
    }


    /**
     * @unauthenticated
     * Log in a user.
     * 
     * If the credential sent is valid, the access token will be returned. 
     * This token has to be included in every request for authorization
     * by including the header - `Authorization: Bearer <access token here>`
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
     * @unauthenticated
     * Send a password reset link to the given user.
     * 
     * The password reset link will be sent in the form of `https://frontendhost.com/reset-password?token='.$token`
     * This means that the frontend app needs to have a route called `reset-password`.
     * This route will receive a `token` parameter that will be used later to verify the password reset request.
     * The view returned by this route should display a form containing:
     * - An email field
     * - A password field
     * - A password_confirmation field
     * - A hidden token field, which should contain the value of the secret $token received by the route.
     * The form should then be posted to the `reset-password` API endpoint.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
 
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT){
            return response()->json([
                "message" => "Password reset link sent successfully",
                "status" => __($status)
            ]);
        }
     
        return response()->json([
            "message" => "We could not send you a password reset link",
            "errors" => [
                "email" => __($status)
            ]
        ], 400);
    }

    /**
     * @unauthenticated
     * Reset the a user's password using the token sent.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET){
            return response()->json([
                "message" => "Password reset successful, please login",
                "status" => __($status)
            ]);
        };
        return response()->json([
            "message" => "Password reset failed ",
            "errors" => [
                "email" => __($status)
            ]
        ], 400);
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
        return new UserResource($request->user());
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
