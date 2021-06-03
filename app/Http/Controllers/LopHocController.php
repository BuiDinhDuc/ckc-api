<?php

namespace App\Http\Controllers;

use App\LopHoc;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LopHocController extends Controller
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
    /** 
     *    @OA\Get(
     *     path="/api/lophoc",
     *     summary="Danh sách lớp học",
     *     tags={"Lớp học"},
     *     description= "Danh sách lớp học",
     *     
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id",
     *       
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     * 
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
     *     security={
     *         {"bearerAuth": {}}
     *     },
     * )
     * 
     */

    public function index(Request $request)
    {
        $lst_lophoc = LopHoc::where('trangthai', '=', 1)->with('bomon')->get();
        return response()->json(['status' => 'success', 'data' => $lst_lophoc]);
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
            'tenlop'             => 'required',
        ], [
            'tenlop.required'             => 'Tên lớp không được bỏ trống',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'code'   => 422,
                'message' => $v->errors()->first(),
            ], 422);
        }

        $lophoc = LopHoc::create([
            'tenlop'    => $request->tenlop,
            'ngaytao'   => Carbon::now(),
            'trangthai' => 1,
            'mabm'      => $request->mabm
        ]);
        if ($lophoc)
            return response()->json(['status' => 'success', 'message' => 'Tạo lớp học thành công'], 200);
        else
            return response()->json(['status' => 'error', 'message' => 'Tạo lớp học không thành công'], 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lophoc = LopHoc::find($id);
        if (!empty($lophoc)) {
            return response()->json(['status' => 'success', 'data' => $lophoc], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Lớp học không tồn tại'], 404);
        }
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
        $v = Validator::make($request->all(), [
            'tenlop'             => 'required',
        ], [
            'tenlop.required'             => 'Tên lớp không được bỏ trống',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'code'   => 422,
                'message' => $v->errors()->first(),
            ], 422);
        }

        $lophoc = LopHoc::find($id);
        if (!empty($lophoc)) {
            $lophoc->tenlop   = $request->tenlop;
            $lophoc->mabm  = $request->mabm;
            $lophoc->save();
            return response()->json(['status' => 'success', 'message' => 'Thành công'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Lớp học không tồn tại'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lophoc = LopHoc::find($id);
        if (!empty($lophoc)) {
            $lophoc->trangthai = 0;
            $lophoc->save();
            return response()->json(['status' => 'success', 'message' => 'Xóa lớp học thành công'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Lớp học không tồn tại'], 404);
        }
    }
}
