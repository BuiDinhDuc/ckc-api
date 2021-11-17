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
use App\GiangVien;
use App\SinhVien;
use App\LopHoc;
use App\LopHocPhan;
use App\MonHoc;
use App\Khoa;
use App\BoMon;
use App\MemberGroup;
use App\PasswordReset;
use Carbon\Carbon;
use App\Jobs\SendMailForgotPassword;
use App\Mail\ResetPassword;
use App\QuenMatKhau;
use App\SinhVienBaiTap;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use JWTAuth;
use Illuminate\Support\Facades\Session;
use File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class AuthController extends Controller
{
    private function guard()
    {
        return Auth::guard();
    }
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }

        return response()->json(['error' => 'refresh_token_error'], 401);
    }
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
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

        $user = User::where('email', $request->email)->where('trangthai', '<>', 1)->first();
        if ($user)  return response()->json([
            'status' => 'error',
            'message' => "Tài khoản của bạn đã bị khóa",
        ], 422);

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
            'status' => "error",
            'message' => 'Sai địa chỉ email hoặc mật khẩu',
        ], 422);
    }
    public function logout()
    {
        $this->guard();
        return response()->json([
            'status' => 'Login successfully',
            'message' => 'Đăng xuất thành công',
        ], 200);
    }

    public function doimatkhau(Request $request, $matk)
    {
        $user = User::where('id', $matk)->first();
        if (Hash::check($request->matkhaucu, $user->password)) {
            $user->password = Hash::make($request->matkhaumoi);
            $user->save();
            return response()->json(['status' => 'success', 'message' => 'Đổi mật khẩu thành công'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Mật khẩu cũ không đúng'], 403);
        }
    }
    public function getUser($matk)
    {
        $user = User::where('id', $matk)->with('giangvien', 'sinhvien')->first();
        return response()->json(['status' => 'success', 'data' => $user], 200);
    }
    public function guimailxacnhan(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!empty($user)) {
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $str =   substr(str_shuffle($permitted_chars), 0, 6);

            $qmk = QuenMatKhau::where('matk', $user->id)->first();
            if (empty($qmk)) {
                QuenMatKhau::create(['matk' => $user->id, 'maxacnhan' => $str]);
            } else {
                $qmk->maxacnhan = $str;
                $qmk->save();
            }
            Mail::to($user->email)->send(new ResetPassword($str));
            return response()->json(['status' => 'success', 'message' => 'OK']);
        } else
            return response()->json(['status' => 'error', 'message' => 'Email không tồn tại'], 404);
    }
    public function resetPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!empty($user)) {
            $qmk = QuenMatKhau::where('matk', $user->id)->where('maxacnhan', $request->maxacnhan)->first();
            if (!empty($qmk)) {
                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $str =   substr(str_shuffle($permitted_chars), 0, 10);
                $user->password = Hash::make($str);
                $user->save();
                return response()->json(['status' => 'success', 'message' => 'Thành công', 'data' => $str], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Mã xác nhận không đúng'], 422);
            }
        } else
            return response()->json(['status' => 'error', 'message' => 'Email không tồn tại'], 404);
    }


    public function demSL()
    {
        $giangvien = GiangVien::where('trangthai', 1)->count();
        $data['giangvien'] = $giangvien;
        $sinhvien = SinhVien::where('trangthai', 1)->count();
        $data['sinhvien'] = $sinhvien;
        $khoa = Khoa::where('trangthai', 1)->count();
        $data['khoa'] = $khoa;
        $bomon = BoMon::where('trangthai', 1)->count();
        $data['bomon'] = $bomon;
        $lophoc = LopHoc::where('trangthai', 1)->count();
        $data['lophoc'] = $lophoc;
        $monhoc = MonHoc::where('trangthai', 1)->count();
        $data['monhoc'] = $monhoc;
        $lophocphan = LopHoc::where('trangthai', 1)->count();
        $data['lophocphan'] = $lophocphan;
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
    public function downloadFolder($mabv)
    {

        $lst_sv_id = SinhVienBaiTap::where('mabv', $mabv)->where('trangthai', 1)->orderBy('id', 'ASC')->pluck('mssv');

        $matk = [];
        foreach ($lst_sv_id as $sv) {
            $sv_id = SinhVien::find($sv)->matk;
            array_push($matk, $sv_id);
        }
        $zipArchive = new ZipArchive();
        $filename = $mabv . '.zip';

        // open and create zip file
        if ($zipArchive->open($filename, ZipArchive::CREATE || ZipArchive::OVERWRITE)) {
            // get all file
            $files  = File::files(public_path('bailam\\' . $mabv));
            if ($files) {
                foreach ($files as $key => $value) {
                    $name = basename($value);
                    $zipArchive->addFile($value, $name);
                }
            } else return response()->json(['status' => 'success', "message" => "Không có file"]);
        }
        $zipArchive->close();

        return response()->json(['status' => 'success', "data" => $filename]);
    }
}
