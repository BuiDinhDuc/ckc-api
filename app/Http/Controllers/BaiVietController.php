<?php

namespace App\Http\Controllers;

use App\BaiLamSinhVien;
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
use App\SinhVien;
use App\LopHocPhan;
use App\SinhVienBaiTap;
use App\SinhVienLopHocPhan;
use App\BangTin;
use App\FileBangTin;
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

        $gv = GiangVien::where('matk', $request->matk)->first();
        if ($request->loaibv == 2) {

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

                // $malh = LopHocPhan::where('id', $request->malhp)->first()->malh;
                $lst_sv = SinhVienLopHocPhan::where('malhp', $request->malhp)->get();
                foreach ($lst_sv as $sv) {
                    SinhVienBaiTap::create([
                        'mssv' => $sv->masv,
                        'mabv'  => $baiviet->id,
                        'trangthai' => 0
                    ]);
                }
                $bangtin = BangTin::create([
                    'noidung'       => $gv->hogv . " " . $gv->tengv . " đã tạo bài tập : " . $baiviet->tieude,
                    'magv'          => $gv->id,
                    'loaibangtin'   => 2,
                    'ngaytao'       => Carbon::now('Asia/Ho_Chi_Minh'),
                    'trangthai'     => 1,
                    'malhp'         => $request->malhp,
                    'mabv'          => $baiviet->id
                ]);

                return response()->json(['status' => 'success', 'message' => 'Thêm thành công']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Thêm thất bại']);
            }
        } else if ($request->loaibv == 3) {
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
                $bangtin = BangTin::create([
                    'noidung'       => $gv->hogv . " " . $gv->tengv . " đã tạo học liệu : " . $baiviet->tieude,
                    'magv'          => $gv->id,
                    'loaibangtin'   => 3,
                    'ngaytao'       => Carbon::now('Asia/Ho_Chi_Minh'),
                    'trangthai'     => 1,
                    'malhp'         => $request->malhp,
                    'mabv'          => $baiviet->id
                ]);

                return response()->json(['status' => 'success', 'message' => 'Thêm thành công']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Thêm thất bại']);
            }
        } else if ($request->loaibv == 4) {

            $baiviet =  BaiViet::create([
                'noidung'        => $request->noidung,
                'ngaytao'        => Carbon::now('Asia/Ho_Chi_Minh'),
                'loaibv'         => 4,
                'matk'           => $request->matk,
                'malhp'          => $request->malhp,
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
                if (!empty($request->dsFileUpload)) {
                    $id_account = $request->matk;
                    return response()->json(['status' => 'success', 'data' => $request->dsFileUpload[0]->getSize()]);

                    $file = $request->dsFileUpload[0];
                    $name_file   = $file->getClientOriginalName();

                    $size        = $file->getSize();
                    $path        = public_path('document/' . $id_account);
                    $file->move($path, $name_file);

                    $child = File::create([
                        'tenfile'       => $name_file,
                        'path'          => 'document/' . $id_account . '/' . $name_file,
                        'dungluong'     => $size,
                        'duoifile'      => '.' . $file->getClientOriginalExtension(),
                        'trangthai'     => 1,
                        'matk'          => $id_account,
                        'ngaytao'       => Carbon::now()->toDateTimeString(),

                    ]);
                }

                return response()->json(['status' => 'success', 'message' => 'Thêm thành công']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Thêm thất bại']);
            }
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

        $magv = GiangVien::where('matk', $request->matk)->first()->id;
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

            $bangtin = BangTin::create([
                'noidung'       => $request->noidung,
                'magv'          => $magv,
                'loaibangtin'   => 1,
                'ngaytao'       => Carbon::now('Asia/Ho_Chi_Minh'),
                'trangthai'     => 1,
                'malhp'         => $request->malhp,
            ]);

            return response()->json(['status' => 'success', 'message' => 'Thêm thành công']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Thêm thất bại']);
        }
    }

    public function suaBaiTap($id, Request $request)
    {


        $baiviet = BaiViet::where('id', $id)->first();
        $gv = GiangVien::where('matk', $request->matk)->first();
        $bangtin = BangTin::where('mabv', $id)->first();
        if ($baiviet->loaibv == 2) {
            $baiviet->update([
                'tieude'         => $request->tieude,
                'noidung'        => $request->noidung,
                'macd'           => $request->macd,
                'ngayketthuc'    => $request->ngayketthuc,
                'gioketthuc'    => $request->gioketthuc,

            ]);


            $bangtin->update([
                'noidung'       => $gv->hogv . " " . $gv->tengv . " đã tạo bài tập : " . $baiviet->tieude,
                'magv'          => $gv->id,
                'loaibangtin'   => 2,
                'ngaytao'       => Carbon::now('Asia/Ho_Chi_Minh'),
                'trangthai'     => 1,
                'mabv'          => $baiviet->id
            ]);
        } elseif ($baiviet->loaibv == 3) {
            $baiviet->update([
                'tieude'         => $request->tieude,
                'noidung'        => $request->noidung,
                'macd'           => $request->macd,
            ]);
            $bangtin->update([
                'noidung'       => $gv->hogv . " " . $gv->tengv . " đã tạo học liệu : " . $baiviet->tieude,
                'magv'          => $gv->id,
                'loaibangtin'   => 3,
                'ngaytao'       => Carbon::now('Asia/Ho_Chi_Minh'),
                'trangthai'     => 1,

                'mabv'          => $baiviet->id
            ]);
        }

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
            return response()->json(['status' => 'success', 'message' => 'Sửa thành công']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Sửa thất bại']);
        }
    }

    public function suaHocLieu($id, Request $request)
    {

        $baiviet = BaiViet::where('id', $id)->first();
        $gv = GiangVien::where('matk', $request->matk)->first();
        $bangtin = BangTin::where('mabv', $id)->first();
        $baiviet->update([
            'tieude'         => $request->tieude,
            'noidung'        => $request->noidung,
            'macd'           => $request->macd,
        ]);
        $bangtin->update([
            'noidung'       => $gv->hogv . " " . $gv->tengv . " đã tạo học liệu : " . $baiviet->tieude,
            'magv'          => $gv->id,
            'loaibangtin'   => 3,
            'ngaytao'       => Carbon::now('Asia/Ho_Chi_Minh'),
            'trangthai'     => 1,
            'malhp'         => $request->malhp,
            'mabv'          => $baiviet->id
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
        $baitap = BaiViet::where('id', $id)->where('loaibv', 2)->with('chude', 'filebaiviets')->withCount('giaobai')->first();

        $sv_danop = SinhVienBaiTap::where([['mabv', $id], ['trangthai', 1]])->with('sinhvien')->get();
        $sv_chuanop = SinhVienBaiTap::where('mabv', $id)->where('trangthai', 0)->with('sinhvien')->get();
        $data['baitap'] = $baitap;
        $data['sv_danop'] = $sv_danop;
        $data['sv_chuanop'] = $sv_chuanop;
        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getChiTietBaiTap($id)
    {
        $baitap = BaiViet::where('id', $id)->with('chude', 'filebaiviets')->withCount('binhluans')->first();
        // $tk = User::where('id', $baitap->matk)->first();
        $giangvien = GiangVien::where('matk', $baitap->matk)->first();
        $file_id = FileBaiViet::where('mabv', $id)->where('trangthai', 1)->pluck('mafile');
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

            $bangtin = BangTin::where('mabv', $baitap->id)->first();
            $bangtin->trangthai = 0;
            $bangtin->save();

            return response()->json(['status' => 'success', 'message' => 'Xóa thành công']);
        }
        return response()->json(['status' => 'error', 'message' => "Không tìm thấy bài tập"], 404);
    }

    public function luuLinkShare(Request $request, $id)
    {
        $sinhvien_id = SinhVien::where('matk', $request->matk)->first()->id;
        $link = BaiLamSinhVien::create([
            'link'       => $request->link,
            'mabv'       => $id,
            'mssv'       => $sinhvien_id,
            'trangthai'  => 2
        ]);
        if (!empty($link))
            return response()->json(['status' => 'success', 'message' => 'Thêm link thành công']);
        else
            return response()->json(['status' => 'error', 'message' => 'Thêm link thất bại']);
    }

    public function getListFileChuaNop(Request $request, $id)
    {
        $sinhvien_id = SinhVien::where('matk', $request->matk)->first()->id;
        $lst_link = BaiLamSinhVien::where('mssv', $sinhvien_id)->where('mabv', $id)->where('trangthai', '=', 2)->whereNotNull('link')->get();
        $lst_file = BaiLamSinhVien::where('mssv', $sinhvien_id)->where('mabv', $id)->where('trangthai', '=', 2)->whereNotNull('mafile')->with('file')->get();
        $lst_van_ban = BaiLamSinhVien::where('mssv', $sinhvien_id)->where('mabv', $id)->where('trangthai', '=', 2)->whereNotNull('van_ban')->get();

        $data['lst_link'] = $lst_link;
        $data['lst_file'] = $lst_file;
        $data['lst_van_ban'] = $lst_van_ban;

        return response()->json(['status' => 'success', 'data' => $data]);
    }
    public function getListFileDaNop(Request $request, $id)
    {
        $sinhvien_id = SinhVien::where('matk', $request->matk)->first()->id;
        $lst_link = BaiLamSinhVien::where('mssv', $sinhvien_id)->where('mabv', $id)->where('trangthai', '=', 1)->whereNotNull('link')->get();
        $lst_file = BaiLamSinhVien::where('mssv', $sinhvien_id)->where('mabv', $id)->where('trangthai', '=', 1)->whereNotNull('mafile')->with('file')->get();
        $lst_van_ban = BaiLamSinhVien::where('mssv', $sinhvien_id)->where('mabv', $id)->where('trangthai', '=', 1)->whereNotNull('van_ban')->get();

        $data['lst_link'] = $lst_link;
        $data['lst_file'] = $lst_file;
        $data['lst_van_ban'] = $lst_van_ban;

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function saveFileBaiTap(Request $request, $id)
    {
        $sinhvien_id = SinhVien::where('matk', $request->matk)->first()->id;
        $link = BaiLamSinhVien::create([
            'mafile'       => $request->mafile,
            'mabv'       => $id,
            'mssv'       => $sinhvien_id,
            'trangthai'  => 2
        ]);
        if (!empty($link))
            return response()->json(['status' => 'success', 'message' => 'Thêm file thành công']);
        else
            return response()->json(['status' => 'error', 'message' => 'Thêm file thất bại']);
    }

    public function deleteBaiLam($id)
    {
        $bailam = BaiLamSinhVien::where('id', $id)->first();
        if (!empty($bailam)) {
            $bailam->trangthai = 0;
            $bailam->save();
            return response()->json(['status' => 'success', 'message' => 'Xóa thành công']);
        } else
            return response()->json(['status' => 'error', 'message' => 'Xóa thất bại']);
    }

    public function nopbai(Request $request, $id)
    {
        $sinhvien_id = SinhVien::where('matk', $request->matk)->first()->id;
        $lst_bailam = BaiLamSinhVien::where('mabv', $id)->where('mssv', $sinhvien_id)->where('trangthai', 2)->get();

        if (!empty($lst_bailam)) {
            foreach ($lst_bailam as $bailam) {
                $bailam->trangthai = 1;
                $bailam->save();
            }

            $sv_bt = SinhVienBaiTap::where('mabv', $id)->where('mssv', $sinhvien_id)->first();
            $sv_bt->trangthai = 1;
            $sv_bt->save();

            return response()->json(['status' => 'success', 'message' => 'Nộp thành công', 'data' => $sv_bt->trangthai]);
        } else
            return response()->json(['status' => 'error', 'message' => 'Nộp thất bại']);
    }

    public function getBaiLam(Request $request, $id)
    {
        // $sinhvien_id = SinhVien::where('matk', $request->matk)->first()->id;
        $lst_link = BaiLamSinhVien::where('mssv', $request->mssv)->where('mabv', $id)->where('trangthai', '=', 1)->whereNotNull('link')->get();

        $lst_file = BaiLamSinhVien::where('mssv',  $request->mssv)->where('mabv', $id)->where('trangthai', '=', 1)->whereNotNull('mafile')->with('file')->get();
        $lst_vanban = BaiLamSinhVien::where('mssv',  $request->mssv)->where('mabv', $id)->where('trangthai', '=', 1)->whereNotNull('van_ban')->get();

        $sv_baitap = SinhVienBaiTap::where('mssv', $request->mssv)->where('mabv', $id)->first();
        $data['lst_link'] = $lst_link;
        $data['lst_file'] = $lst_file;
        $data['lst_vanban'] = $lst_vanban;
        $data['diem'] = $sv_baitap->diem;
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function getListDienDan($malhp)
    {
        $lst_diendan = BaiViet::where('malhp', $malhp)->where('trangthai', 1)->where('loaibv', 4)->with('taikhoan', 'lophocphan', 'filebaiviets', 'binhluans')->withCount('binhluans')->orderBy('id', 'DESC')->get();
        return response()->json(['status' => 'success', 'data' => $lst_diendan]);
    }

    public function xoaDienDan($id)
    {
        $baiviet = BaiViet::where('id', $id)->first();
        if (!empty($baiviet)) {
            $baiviet->trangthai = 0;
            $baiviet->save();

            return response()->json(['status' => 'success', 'message' => 'Thành công']);
        } else
            return response()->json(['status' => 'error', 'message' => 'Thất bại']);
    }

    public function getDienDan($id)
    {
        $baiviet = BaiViet::where('id', $id)->where('trangthai', 1)
            // ->whereHas('filebaiviets',function($query){
            //     $query->where('trangthai',1);
            // })
            ->with('filebaiviets')->first();
        return response()->json(['status' => 'success', 'data' => $baiviet]);
    }

    public function updateDienDan(Request $request, $id)
    {
        $baiviet = BaiViet::where('id', $id)->first();
        if (!empty($baiviet)) {
            $baiviet->update([
                'noidung'       => $request->noidung,
            ]);
            if (!empty($request->dsFile)) {
                $dsFile = explode(',', $request->dsFile);
                foreach ($dsFile as $file) {
                    FileBaiViet::create([
                        'mafile'    => $file,
                        'mabv' => $baiviet->id,
                        'trangthai' => 1
                    ]);
                }
            }
            return response()->json(['status' => 'success', 'message' => "Sửa thành công"], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => "Không tìm thấy"], 404);
        }
    }

    public function deleteFileBaiViet($id)
    {
        $filebaiviets = FileBaiViet::where('id', $id)->first();
        if (!empty($filebaiviets)) {
            $filebaiviets->trangthai = 0;
            $filebaiviets->save();
            return response()->json(['status' => 'success', 'message' => "Xóa thành công"], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => "Không tìm thấy"], 404);
        }
    }
    public function deleteFileBangTin($id)
    {
        $filebangtin = FileBangTin::where('id', $id)->first();
        if (!empty($filebangtin)) {
            $filebangtin->trangthai = 0;
            $filebangtin->save();
            return response()->json(['status' => 'success', 'message' => "Xóa thành công"], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => "Không tìm thấy"], 404);
        }
    }

    public function getListFileDienDan($id)
    {
        $filebaiviets = FileBaiViet::where('id', $id)->first();
        if (!empty($filebaiviets)) {
            $filebaiviets->trangthai = 0;
            $filebaiviets->save();
            return response()->json(['status' => 'success', 'message' => "Xóa thành công"], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => "Không tìm thấy"], 404);
        }
    }

    public function nopvanban(Request $request, $id)
    {
        $sinhvien_id = SinhVien::where('matk', $request->matk)->first()->id;
        $vanban = BaiLamSinhVien::create([
            'van_ban'    => $request->vanban,
            'mabv'       => $id,
            'mssv'       => $sinhvien_id,
            'trangthai'  => 2
        ]);
        if (!empty($vanban))
            return response()->json(['status' => 'success', 'message' => 'Thành công']);
        else
            return response()->json(['status' => 'error', 'message' => 'Thất bại']);
    }
    public function huynopbai(Request $request, $id)
    {
        $sinhvien_id = SinhVien::where('matk', $request->matk)->first()->id;
        $lst_bailam = BaiLamSinhVien::where('mabv', $id)->where('mssv', $sinhvien_id)->where('trangthai', 1)->get();

        if (!empty($lst_bailam)) {
            foreach ($lst_bailam as $bailam) {
                $bailam->trangthai = 2;
                $bailam->save();
            }

            $sv_bt = SinhVienBaiTap::where('mabv', $id)->where('mssv', $sinhvien_id)->first();
            $sv_bt->trangthai = 0;
            $sv_bt->save();

            return response()->json(['status' => 'success', 'message' => 'Nộp thành công', 'data' => $sv_bt->trangthai]);
        } else
            return response()->json(['status' => 'error', 'message' => 'Nộp thất bại']);
    }

    public function chamDiem(Request $request)
    {
        $sv_bt = SinhVienBaiTap::where('mssv', $request->mssv)->where('mabv', $request->mabv)->first();
        $sv_bt->diem = $request->diem;
        $sv_bt->save();
        return response()->json(['status' => 'success', 'message' => 'success']);
    }
    public function getDiem(Request $request)
    {
        $sinhvien_id = SinhVien::where('matk', $request->matk)->first()->id;
        $sv_bt = SinhVienBaiTap::where('mssv', $sinhvien_id)->where('mabv', $request->mabv)->first();
        return response()->json(['status' => 'success', 'data' => $sv_bt->diem]);
    }
    public function deleteFileDinhKem($id)
    {
        $bv_file = FileBaiViet::where('id', $id)->first();
        $bv_file->trangthai = 0;
        $bv_file->save();
        return response()->json(['status' => 'success', 'message' => "success"]);
    }
    public function getStatus(Request $request, $id)
    {
        $mssv = SinhVien::where('matk', $request->matk)->first();
        $sv_bt = SinhVienBaiTap::where('mssv', $mssv->id)->where('mabv', $id)->first();
        return response()->json(['status' => 'success', 'data' => $sv_bt->trangthai]);
    }
}
