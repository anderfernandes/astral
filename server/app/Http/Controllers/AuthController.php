<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /** Registers a new user.
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request): Response
    {
        $validator = Validator::make($request->input(), [
            'firstname' => ['required', 'min:2', 'max:64'],
            'lastname' => ['required', 'min:2', 'max:64'],
            'email' => ['required', 'email', 'min:3', 'max:64', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8', 'max:64'],
        ]);

        if ($validator->fails()) {
            return response([
                'message' => 'Invalid form data',
                'errors' => $validator->errors()
            ], 422);
        }

        $visitor_role = DB::table('roles')->select('id')
            ->where('name', 'like', 'visitor')->first();

        if ($visitor_role == null) {
            return response()->noContent(422);
        }

        $user = (new User)->create([
            'staff' => false,
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input("password")),
            'role_id' => $visitor_role->id
        ]);

        $user->sendEmailVerificationNotification();

        return response()->noContent(201);
    }

    /**
     * Authenticates user.
     * TODO: do not log in accounts that have not been activated
     */
    public function login(Request $request): Response
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => ['required', 'min:2', 'max:64'],
            'password' => ['required']
        ]);

        if ($validator->fails()) {
            return response([
                'message' => 'Invalid credentials.'
            ], 422);
        }

        // TODO: remember password

        if (!Auth::attempt($credentials)) {
            return response()->noContent(401);
        }

        $token = $request->user()->createToken('token')->plainTextToken;

        return response(['token' => $token, 'path' => $request->user()->staff ? '/admin' : '/'], 200);
    }

    /**
     * Logs out a user.
     */
    public function logout(Request $request): Response
    {
        if (!Auth::check()) {
            return response()->noContent(422);
        }

        $request->user()->currentAccessToken()->delete();

        return response()->noContent(200);
    }

    /**
     * Sends a reset password link to a registered user.
     */
    public function forgot(Request $request): Response
    {
        $validator = Validator::make($request->only(['email']), [
            'email' => ['required', 'email']
        ]);

        if ($validator->fails()) {
            return response()->noContent(422);
        }

        $status = Password::sendResetLink($request->only('email'));

        return response([
            'status' => $status, 'a' => config('trustedproxy.proxies'), 'b' => $request->isFromTrustedProxy()
        ], $status === Password::RESET_LINK_SENT ? 200 : 404);
    }

    /**
     * Verifies a user account.
     * TODO: verify hash and activate account
     */
    public function verify(string $id, string $hash): Response
    {
        //$user =  (new \App\Models\User())->find($id);

        //$user->markEmailAsVerified();

        return response()->noContent(302);
    }

    /**
     * Resets a user's password.
     */
    public function forgotPassword(Request $request): Response
    {
        $validator = Validator::make($request->only('email', 'password', 'password_confirmation', 'token'), [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->noContent(422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(\Illuminate\Support\Str::random(60));

                $user->save();

                event(new \Illuminate\Auth\Events\PasswordReset($user));
            }
        );

        return response(['status' => $status], $status === Password::PASSWORD_RESET ? 200 : 404);
    }
}
