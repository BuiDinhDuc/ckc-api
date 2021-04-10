<?php

namespace App\Http\Controllers;

use App\BaiViet;
use Illuminate\Http\Request;

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
    public function getDiscussionPostList(Request $request)
    {
        $lhp_id = $request->header('id');
        $lst_post = BaiViet::where([
            ['trangthai', 1],
            ['malhp', $lhp_id],
            ['loaibv', 2]
        ])->with('giangvien', 'sinhvien')->get();

        if (!empty($lst_post))
            return response()->json(['status' => 'success', 'data' => $lst_post], 200);
        else
            return response()->json(['status' => 'failed', 'message' => 'Không có bài thảo luận nào'], 200);
    }

    public function getTeacherPostList(Request $request)
    {
        $lhp_id = $request->header('id');
        $lst_post = BaiViet::where([
            ['trangthai', 1],
            ['malhp', $lhp_id],
            ['loaibv', 1]
        ])->with('giangvien', 'chude')->get();

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
    public function store(Request $request)
    {
        //
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
        ])->with('giangvien')->get();

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
