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
            'expires_in' => $this->guard()->factory()->getTTL() * 604800
        ];
    }
    /**
     * * @OA\Post(
     *     path="/api/login",
     *     summary="Login",
     *     tags={"Auth"},
     *     description= "Login",
     *     operationId="login",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="email",
     *       
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="password",
     *       
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid tag value",
     *     ),
     * )
     * 
     */
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
            $account =  User::where('id', Auth::user()->id)->first();
            $account =  array_merge($account->toArray(), $this->respondWithToken($token));
            return response()->json([
                'status' => 'Login successfully',
                'data' => $account,
            ], 200);
        }
        return response()->json([
            'status' => 'Invalid account or password',
        ], 422);
    }
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'Login successfully',
            'message' => 'Đăng xuất thành công',
        ], 422);
    }
}
