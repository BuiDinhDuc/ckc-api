<?php

namespace App\Http\Controllers;

use App\BoMon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BoMonController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * *  @OA\Get(
     *     path="/api/bomon",
     *     summary="Danh sách bộ môn",
     *     tags={"Bộ môn"},
     *     description= "Danh sách bộ môn",
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
     */
    public function index(Request $request)
    {
        $lst_bomon = BoMon::where('trangthai', '<>', 0)->withCount('lophocs')->with('khoa')->orderBy('id', 'DESC')->paginate(10);

        return response()->json(['status' => 'success', 'data' => $lst_bomon], 200);
    }

    public function getAll(Request $request)
    {
        $lst_bomon = BoMon::where('trangthai', '<>', 0)->withCount('lophocs')->with('khoa')->get();

        return response()->json(['status' => 'success', 'data' => $lst_bomon], 200);
    }

    /**
     *    @OA\Get(
     *     path="/api/bomon/detail",
     *     summary="Chi tiết bộ môn",
     *     tags={"Bộ môn"},
     *     description= "Chi tiết bộ môn",
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
     */

    public function show(Request $request)
    {
        $bomon = BoMon::where('id', $request->id)->with('lophocs', 'khoa')->get();
        return response()->json(['status' => 'success', 'data' => $bomon], 200);
    }

    /**
     *   @OA\Post(
     *     path="/api/bomon/create",
     *     summary="Thêm bộ môn",
     *     tags={"Bộ môn"},
     *     description= "Thêm bộ môn",
     *      @OA\Parameter(
     *         name="tenbm",
     *         in="query",
     *         description="tenbm",
     *       
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *  *      @OA\Parameter(
     *         name="makhoa",
     *         in="query",
     *         description="makhoa",
     *       
     *         @OA\Schema(
     *             type="integer",
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
     *     security={
     *         {"bearerAuth": {}}
     *     },
     * )
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'tenbm'          => 'required|unique:App\BoMon,tenbm',

        ], [
            'tenbm.unique'             => 'Tên bộ môn không được trùng',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'code'   => 422,
                'message' => $v->errors()->first(),
            ], 422);
        }
        $bomon = new BoMon();
        $bomon->tenbm       = $request->tenbm;
        $bomon->trangthai   = 1;
        $bomon->makhoa        = $request->makhoa;
        $bomon->save();
        $lst_bomon = BoMon::where('trangthai', 1)->get();
        return response()->json(['status' => 'success', 'message' => "Thêm bộ môn thành công"], 200);
    }
    /**
     *   @OA\Put(
     *     path="/api/bomon/update",
     *     summary="Chỉnh sửa bộ môn",
     *     tags={"Bộ môn"},
     *     description= "Chỉnh sửa bộ môn",
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id",
     *       
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *      @OA\Parameter(
     *         name="tenbm",
     *         in="query",
     *         description="tenbm",
     *       
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *        @OA\Parameter(
     *         name="makhoa",
     *         in="query",
     *         description="makhoa",
     *       
     *         @OA\Schema(
     *             type="integer",
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
     *     security={
     *         {"bearerAuth": {}}
     *     },
     * )
     */

    public function update(Request $request)
    {
        $bomon = BoMon::find($request->id);
        $bomon->tenbm = $request->tenbm;
        $bomon->makhoa = $request->makhoa;
        $bomon->save();
        $lst_bomon = BoMon::where('trangthai', 1)->get();
        return response()->json(['status' => 'success', 'message' => "Sửa bộ môn thành công"], 200);
    }

    /**
     *   @OA\Delete(
     *     path="/api/bomon/delete",
     *     summary="Xóa bộ môn",
     *     tags={"Bộ môn"},
     *     description= "Xóa bộ môn",
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id",
     *       
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     
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
     *     security={
     *         {"bearerAuth": {}}
     *     },
     * )
     */


    public function destroy(Request $request)
    {
        $bomon = BoMon::find($request->id);
        $bomon->trangthai = 0;
        $bomon->save();
        $lst_bomon = BoMon::where('trangthai', 1)->get();
        return response()->json(['status' => 'success', 'message' => "Xóa thành công"], 200);
    }

    public function lock(Request $request)
    {
        $bomon = BoMon::find($request->id);
        $bomon->trangthai = 2;
        $bomon->save();
        // $lst_bomon = BoMon::where('trangthai', 1)->get();
        $lst_bomon = BoMon::where('trangthai', '<>', 0)->withCount('lophocs')->with('khoa')->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['status' => 'success', 'message' => "Đã khóa", 'data' => $lst_bomon], 200);
    }
    public function unlock(Request $request)
    {
        $bomon = BoMon::find($request->id);
        $bomon->trangthai = 1;
        $bomon->save();
        // $lst_bomon = BoMon::where('trangthai', 2)->get();
        $lst_bomon = BoMon::where('trangthai', '<>', 0)->withCount('lophocs')->with('khoa')->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['status' => 'success', 'message' => "Đã mở khóa", 'data' => $lst_bomon], 200);
    }

    public function timkiemBM(Request $request)
    {
        if ($request->key_word == null) {
            $lst_bomon = BoMon::where('trangthai', '<>', 0)->withCount('lophocs')->with('khoa')->orderBy('id', 'DESC')->paginate(10);
            if (!empty($lst_bomon))
                return response()->json(['status' => 'success', 'data' => $lst_bomon], 200);
        } else {
            $lst_bomon = BoMon::where([['tenbm', 'like', '%' . $request->key_word . '%'], ['trangthai', '<>', 0]])->withCount('lophocs')->with('khoa')->orderBy('id', 'DESC')->paginate(10);
            if (!empty($lst_bomon))
                return response()->json(['status' => 'success', 'data' => $lst_bomon], 200);
        }
    }
}
