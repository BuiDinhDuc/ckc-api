<?php

namespace App\Http\Controllers;

use App\BaiViet;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\File;
use App\FileBaiViet;
use Carbon\Carbon;

class BaiVietController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     *   @OA\Get(
     *     path="/api/baiviet/discussion-post",
     *     summary="Danh sách bài viết thảo luận",
     *     tags={"Bài viết"},
     *     description= "Danh sách bài viết thảo luận",
     *       @OA\Parameter(
     *         name="id",
     *         in="header",
     *         description="lhp_id",
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
     *     security={
     *         {"bearerAuth": {}}
     *     },
     * )
     */
    public function getDiscussionPostList(Request $request)
    {
        $lhp_id = $request->header('id');
        $lst_post = BaiViet::where([
            ['trangthai', 1],
            ['malhp', $lhp_id],
            ['loaibv', 2]
        ])->with('giangvien', 'sinhvien', 'binhluans')->get();

        if (!empty($lst_post))
            return response()->json(['status' => 'success', 'data' => $lst_post], 200);
        else
            return response()->json(['status' => 'failed', 'message' => 'Không có bài thảo luận nào'], 200);
    }

    /**
     *   @OA\Get(
     *     path="/api/baiviet/teacher-post",
     *     summary="Danh sách bài viết giáo viên",
     *     tags={"Bài viết"},
     *     description= "Danh sách bài viết giáo viên",
     *       @OA\Parameter(
     *         name="id",
     *         in="header",
     *         description="lhp_id",
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
     *     security={
     *         {"bearerAuth": {}}
     *     },
     * )
     */

    public function getTeacherPostList(Request $request)
    {
        $lhp_id = $request->header('id');
        $lst_post = BaiViet::where([
            ['trangthai', 1],
            ['malhp', $lhp_id],
            ['loaibv', 1]
        ])->with('giangvien', 'binhluans')->groupBy('macd')->get();

        if (!empty($lst_post))
            return response()->json(['status' => 'success', 'data' => $lst_post], 200);
        else
            return response()->json(['status' => 'failed', 'message' => 'Không có bài thảo luận nào'], 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     *   @OA\Post(
     *     path="/api/baiviet/create",
     *     summary="Tạo bài viết",
     *     tags={"Bài viết"},
     *     description= "Tạo bài viết",
     *       @OA\Parameter(
     *         name="noidung",
     *         in="query",
     *         description="noidung",
     *       
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *  @OA\Parameter(
     *         name="tieude",
     *         in="query",
     *         description="tieude",
     *       
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *  *  @OA\Parameter(
     *         name="loaibv",
     *         in="query",
     *         description="loaibv",
     *       
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *    @OA\Parameter(
     *         name="malhp",
     *         in="query",
     *         description="malhp",
     *       
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *  @OA\Parameter(
     *         name="macd",
     *         in="query",
     *         description="macd",
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
            'tieude'             => 'required',
            'noidung'            => 'required',
        ], [
            'tieude.required'             => 'Tiêu đề không được bỏ trống',
            'noidung.required'      => 'Nội dung không được bỏ trống',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'code'   => 422,
                'message' => $v->errors()->first(),
            ], 422);
        }

        $baiviet =  BaiViet::create([
            'tieude'     => $request->tieude,
            'noidung'    => $request->noidung,
            'ngaytao'    => Carbon::now('Asia/Ho_Chi_Minh'),
            'loaibv'     => $request->loaibv,
            'matk'       => Auth::user()->id,
            'malhp'      => $request->malhp,
            'macd'      => $request->macd,
            'trangthai'  => 1,
        ]);

        if (!empty($baiviet)) {
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $key => $file) {
                    $name_file = $file->getClientOriginalName();
                    if (isset($request->tenthumuc)) {
                        $path = public_path('document/' . $baiviet->malhp . '/' . $request->tenthumuc);
                    } else {
                        $path = public_path('document/' . $baiviet->malhp);
                    }
                    $file->move($path, $name_file);
                    // $parent = File::find($account->document_id);
                    // $child = $parent->children()->create([
                    //     'name' => $name_file,
                    //     'filterPath' => isset($request->folder_name) ? $request->folder_name : '/',
                    //     'size' => $size,
                    //     'type' => '.' . $file->getClientOriginalExtension()
                    // ]);
                }
            }
            return response()->json(['status' => 'success', 'message' => 'Thêm thành công']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Thêm thất bại']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $lhp_id = $request->header('id');
        $lst_post = BaiViet::where([
            ['trangthai', 1],
            ['malhp', $lhp_id],
            ['loaibv', 1],
            ['id']
        ])->with('giangvien', 'binhluan')->get();

        if (!empty($lst_post))
            return response()->json(['status' => 'success', 'data' => $lst_post], 200);
        else
            return response()->json(['status' => 'failed', 'message' => 'Không có bài thảo luận nào'], 404);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $baiviet = BaiViet::find($request->id);
        if(!empty($baiviet)){
            $baiviet->trangthai = 0;
            $baiviet->save();
        }
    }
}
