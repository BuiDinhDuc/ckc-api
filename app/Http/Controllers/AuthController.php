<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Jobs\SendActivateEmail;
use App\ActivateAccountMember;
use App\AccountMember;
use App\Documents;
use App\MemberGroup;
use App\PasswordReset;
use Carbon\Carbon;
use App\Jobs\SendMailForgotPassword;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    private function guard()
    {
        return Auth::guard();
    }
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ];
    }
    public function login(Request $request)
    {
        $v = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password'  => 'required|min:3',
            ],
            [
                'email.required' => 'The email field is required.'
            ]
        );

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()->first(),
            ], 422);
        }
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            // var_dump($token);exit;
            $account =  User::where('matk', Auth::user()->matk)->first();
            $account =  array_merge($account->toArray(), $this->respondWithToken($token));
            return response()->json([
                'status' => 'Login success',
                'userData' => $account,
            ], 200);
        }
        return response()->json([
            'status' => 'Invalid account or password',
        ], 200);
    }
}
