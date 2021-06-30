<?php

namespace App\Http\Controllers;

use App\BaiViet;
use App\ChuDe;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\File;
use App\FileBaiViet;
use Carbon\Carbon;
use App\User;
use App\GiangVien;
use App\BinhLuan;

class BaiVietController extends Controller
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
    public function taoBaiTap(Request $request)
    {
        // $v = Validator::make($request->all(), [
        //     'tieude'             => 'required',
        //     'noidung'            => 'required',
        // ], [
        //     'tieude.required'             => 'Tiêu đề không được bỏ trống',
        //     'noidung.required'      => 'Nội dung không được bỏ trống',
        // ]);
        // if ($v->fails()) {
        //     return response()->json([
        //         'status' => 'error',
        //         'code'   => 422,
        //         'message' => $v->errors()->first(),
        //     ], 422);
        // }


        $baiviet =  BaiViet::create([
            'tieude'         => $request->tieude,
            'noidung'        => $request->noidung,
            'ngaytao'        => Carbon::now('Asia/Ho_Chi_Minh'),
            'loaibv'         => 2,
            'matk'           => $request->matk,
            'malhp'          => $request->malhp,
            'macd'           => $request->macd,
            'ngayketthuc'    => $request->ngayketthuc,
            'gioketthuc'    => $request->gioketthuc,
            'trangthai'      => 1,
        ]);

        if (!empty($baiviet)) {
            if (!empty($request->dsFile)) {
                $dsFile = explode(',', $request->dsFile);
                foreach ($dsFile as $file_id) {
                    FileBaiViet::create([
                        'mafile'    => $file_id,
                        'mabv'      => $baiviet->id,
                        'trangthai' => 1
                    ]);
                }
            }

            return response()->json(['status' => 'success', 'message' => 'Thêm thành công']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Thêm thất bại']);
        }
    }

    public function taoHocLieu(Request $request)
    {
        // $v = Validator::make($request->all(), [
        //     'tieude'             => 'required',
        //     'noidung'            => 'required',
        // ], [
        //     'tieude.required'             => 'Tiêu đề không được bỏ trống',
        //     'noidung.required'      => 'Nội dung không được bỏ trống',
        // ]);
        // if ($v->fails()) {
        //     return response()->json([
        //         'status' => 'error',
        //         'code'   => 422,
        //         'message' => $v->errors()->first(),
        //     ], 422);
        // }


        $baiviet =  BaiViet::create([
            'tieude'         => $request->tieude,
            'noidung'        => $request->noidung,
            'ngaytao'        => Carbon::now('Asia/Ho_Chi_Minh'),
            'loaibv'         => 3,
            'matk'           => $request->matk,
            'malhp'          => $request->malhp,
            'macd'           => $request->macd,
            'trangthai'      => 1,
        ]);

        if (!empty($baiviet)) {
            if (!empty($request->dsFile)) {
                $dsFile = explode(',', $request->dsFile);
                foreach ($dsFile as $file_id) {
                    FileBaiViet::create([
                        'mafile'    => $file_id,
                        'mabv'      => $baiviet->id,
                        'trangthai' => 1
                    ]);
                }
            }

            return response()->json(['status' => 'success', 'message' => 'Thêm thành công']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Thêm thất bại']);
        }
    }

    public function suaBaiTap($id, Request $request)
    {

        $baiviet = BaiViet::where('id', $id)->first();
        $baiviet->update([
            'tieude'         => $request->tieude,
            'noidung'        => $request->noidung,
            'macd'           => $request->macd,
            'ngayketthuc'    => $request->ngayketthuc,
            'gioketthuc'    => $request->gioketthuc,

        ]);

        if (!empty($baiviet)) {
            if (!empty($request->dsFile)) {
                $dsFile = explode(',', $request->dsFile);


                $dsFile_BaiViet = FileBaiViet::where('mabv', $id)->pluck('mafile');

                // return response()->json(['status' => 'success', 'data1' => $dsFile, 'data2' => $dsFile_BaiViet]);

                if (count($dsFile_BaiViet) > 0) {
                    return response()->json(['status' => 'success', 'data' => $dsFile_BaiViet]);

                    $dsFileMoi = array_diff($dsFile, $dsFile_BaiViet);
                    $dsFileCu = array_diff($dsFile_BaiViet, $dsFile);
                } else {
                    $dsFileMoi = $dsFile;
                    $dsFileCu = [];
                }
                foreach ($dsFileMoi as $file_id) {
                    FileBaiViet::create([
                        'mafile'    => $file_id,
                        'mabv'      => $baiviet->id,
                        'trangthai' => 1
                    ]);
                }
                foreach ($dsFileCu as $file_id) {
                    $file = FileBaiViet::where([
                        'mafile'    => $file_id,
                        'mabv'      => $baiviet->id,
                        'trangthai' => 1
                    ]);
                    $file->trangthai = 0;
                    $file->save();
                }
            } else {
                $dsFileCu = FileBaiViet::where('mabv', $id)->get();
                foreach ($dsFileCu as $file) {
                    $file->trangthai = 0;
                    $file->save();
                }
            }

            return response()->json(['status' => 'success', 'message' => 'Sửa thành công']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Sửa thất bại']);
        }
    }

    public function suaHocLieu($id, Request $request)
    {

        $baiviet = BaiViet::where('id', $id)->first();
        $baiviet->update([
            'tieude'         => $request->tieude,
            'noidung'        => $request->noidung,
            'macd'           => $request->macd,


        ]);

        if (!empty($baiviet)) {
            if (!empty($request->dsFile)) {
                $dsFile = explode(',', $request->dsFile);
                $dsFile_BaiViet = FileBaiViet::where('mabv', $id)->pluck('mafile');
                if (count($dsFile_BaiViet) > 0) {
                    return response()->json(['status' => 'success', 'data' => $dsFile_BaiViet]);

                    $dsFileMoi = array_diff($dsFile, $dsFile_BaiViet);
                    $dsFileCu = array_diff($dsFile_BaiViet, $dsFile);
                } else {
                    $dsFileMoi = $dsFile;
                    $dsFileCu = [];
                }
                foreach ($dsFileMoi as $file_id) {
                    FileBaiViet::create([
                        'mafile'    => $file_id,
                        'mabv'      => $baiviet->id,
                        'trangthai' => 1
                    ]);
                }
                foreach ($dsFileCu as $file_id) {
                    $file = FileBaiViet::where([
                        'mafile'    => $file_id,
                        'mabv'      => $baiviet->id,
                        'trangthai' => 1
                    ]);
                    $file->trangthai = 0;
                    $file->save();
                }
            } else {
                $dsFileCu = FileBaiViet::where('mabv', $id)->get();
                foreach ($dsFileCu as $file) {
                    $file->trangthai = 0;
                    $file->save();
                }
            }

            return response()->json(['status' => 'success', 'message' => 'Sửa thành công']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Sửa thất bại']);
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
        if (!empty($baiviet)) {
            $baiviet->trangthai = 0;
            $baiviet->save();
        }
    }
    public function getAllBaiTap($malhp)
    {
        $lst_baitapkhongchude = BaiViet::where([

            ['malhp', $malhp],
            ['trangthai', 1],
            ['macd', 0]
        ])->whereIn('loaibv', [2, 3])->orderBy('id', 'DESC')->get();

        $lst_baitaptheochude = ChuDe::where([
            ['trangthai', 1],
            ['malhp', $malhp]
        ])->orderBy('id', 'DESC')->with('baitapscochude')->get();

        $data['lst_baitapkhongchude'] = $lst_baitapkhongchude;
        $data['lst_baitaptheochude'] = $lst_baitaptheochude;
        return response()->json(['message' => 'success', 'data' => $data]);
    }

    public function getBaiTap($id)
    {
        $baitap = BaiViet::where('id', $id)->where('loaibv', 2)->with('chude', 'filebaiviets')->first();
        return response()->json(['status' => 'success', 'data' => $baitap]);
    }
    public function getChiTietBaiTap($id)
    {
        $baitap = BaiViet::where('id', $id)->where('loaibv', 2)->with('chude', 'filebaiviets')->withCount('binhluans')->first();
        $tk = User::where('id', $baitap->matk)->first();
        $giangvien = GiangVien::where('matk', $tk->id)->first();
        $file_id = FileBaiViet::where('mabv', $id)->pluck('mafile');
        $dsFile = File::whereIn('id', $file_id)->get();
        // $binhluan = BinhLuan::where('mabv', $id)->where('trangthai', '<>', 0)->with('taikhoan')->get();
        $data['baitap'] = $baitap;
        $data['giangvien'] = $giangvien;
        $data['file'] = $dsFile;
        // $data['binhluan'] = $binhluan;
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getHocLieu($id)
    {
        $baitap = BaiViet::where('id', $id)->where('loaibv', 3)->with('chude', 'filebaiviets')->first();
        return response()->json(['status' => 'success', 'data' => $baitap]);
    }

    public function getDSBinhLuan($id)
    {
        $binhluan = BinhLuan::where('mabv', $id)->where('trangthai', '<>', 0)->with('taikhoan')->orderBy('id', 'DESC')->get();
        return response()->json(['status' => 'success', 'data' => $binhluan]);
    }

    public function deleteBaiTap($id)
    {
        $baitap = BaiViet::where('id', $id)->whereIn('loaibv', [2, 3])->first();

        if (!empty($baitap)) {
            $baitap->trangthai = 0;
            $baitap->save();

            return response()->json(['status' => 'success', 'message' => 'Xóa thành công']);
        }
        return response()->json(['status' => 'error', 'message' => "Không tìm thấy bài tập"], 404);
    }
}
