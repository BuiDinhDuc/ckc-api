<?php

namespace App\Http\Controllers;

use App\BinhLuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class BinhLuanController extends Controller
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
        $binhluan = BinhLuan::where('trangthai', '=', 1)->get();
        $binhluan->groupBy('mabv');
        return response()->json(['status' => 'success', 'data' => $binhluan], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'noidung' => 'required',
        ], [
            'noidung.required'  => 'Nội dung không được bỏ trống',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'code'   => 422,
                'message' => $v->errors()->first(),
            ], 422);
        }
        $binhluan = BinhLuan::create([
            'noidung' => $request->noidung,
            'ngaytao' => Carbon::now('Asia/Ho_Chi_Minh'),
            'mabv'    =>  $request->mabv,
            'matk'    => $request->matk,
        ]);
        if (!empty($binhluan)) {
            return response()->json(['status' => 'success', 'message' => 'Bình luận thành công'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Bình luận không thành công'], 404);
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
        //
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
        $binhluan = BinhLuan::where('id', $id)->first();
        if (!empty($binhluan)) {
            $binhluan->noidung = $request->noidung;
            $binhluan->save();
            return response()->json(['status' => 'success', 'message' => 'Sửa bình luận thành công'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'Không tìm thấy bình luận'], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $binhluan = BinhLuan::find($id);
        if (!empty($binhluan)) {
            $binhluan->trangthai = 0;
            $binhluan->save();
            return response()->json(['status' => 'success', 'message' => 'Xóa bình luận thành công'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy bình luận'], 404);
        }
    }
    public function addBinhLuanBangTin(Request $request)
    {
        $v = Validator::make($request->all(), [
            'noidung' => 'required',
        ], [
            'noidung.required'  => 'Nội dung không được bỏ trống',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'code'   => 422,
                'message' => $v->errors()->first(),
            ], 422);
        }
        $binhluan = BinhLuan::create([
            'noidung' => $request->noidung,
            'ngaytao' => Carbon::now('Asia/Ho_Chi_Minh'),
            'mabt'    =>  $request->mabt,
            'matk'    => $request->matk,
        ]);
        if (!empty($binhluan)) {
            return response()->json(['status' => 'success', 'message' => 'Bình luận thành công'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Bình luận không thành công'], 404);
        }
    }
}
