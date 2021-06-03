<?php

namespace App\Http\Controllers;

use App\GiangVien;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class GiangVienController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lst_giangvien = GiangVien::where('trangthai','<>',0)->get();

        return response()->json(['status' => 'success','data' => $lst_giangvien],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        do {
            $email = rand(0, 9999999999);
            $len = strlen($email);
            for ($i = 0; $i < 10 - $len; $i++) {
                $email = '0' . $email;
            }
            $email .= '@caothang.edu.vn';
            $user = User::where('email', $email)->first();
        } while (!empty($user));

        $user = User::create([
            'email' => $email,
            'trangthai' => 1,
            'password'  => Hash::make($request->cccd)
        ]);

        if (!empty($user)) {
            $gv = GiangVien::create([
                'hogv' => $request->hogv,
                'tengv' => $request->tengv,
                'ngaysinh' => $request->ngaysinh,
                'gioitinh' => $request->gioitinh,
                'sdt' => $request->sdt,
                'cccd' => $request->cccd,
                'matk' => $user->id,
                'mabm' => $request->bomon,
                'province_id' => $request->tinh,
                'district_id' => $request->huyen,
                'ward_id' => $request->xa,
                'trangthai' => 1,

            ]);
            if (!empty($gv)) {
                return response()->json(['status' => 'success', 'message' => 'Thêm thành công'], 200);
            }
            return response()->json(['status' => 'error', 'message' => 'Thêm thất bại'], 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sv = GiangVien::where('id',$id)->with('bomon', 'taikhoan','lophocphans' ,'tinh', 'huyen', 'xa')->first();
        if (!empty($sv))
            return response()->json(['status' => 'success', 'data' => $sv], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gv = GiangVien::find($id);
        $gv->update([
            'hogv' => $request->hogv,
            'tengv' => $request->tengv,
            'ngaysinh' => $request->ngaysinh,
            'gioitinh' => $request->gioitinh,
            'sdt' => $request->sdt,
            'cccd' => $request->cccd,
            'mabm' => $request->bomon,
            'province_id' => $request->tinh,
            'district_id' => $request->huyen,
            'ward_id' => $request->xa,
            'trangthai' => 1,

        ]);
        if (!empty($gv)) {
            return response()->json(['status' => 'success', 'message' => 'Sửa thành công'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'Sửa thất bại'], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gv = GiangVien::find($id);
        if (!empty($gv)) {
            if ($gv->trangthai == 0) {
                return response()->json(['status' => 'error', 'message' => 'Giảng viên đã bị xóa'], 403);
            } else {
                $gv->trangthai = 0;
                $gv->save();
                return response()->json(['status' => 'success', 'message' => 'Xóa thành công'], 200);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Giảng viên không tồn tại'], 404);
        }
    }
}
