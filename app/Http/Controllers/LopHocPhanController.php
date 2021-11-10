<?php

namespace App\Http\Controllers;

use App\BaiViet;
use App\Exports\StudentExport;
use App\GiangVien;
use App\LopHoc;
use App\LopHocPhan;
use App\MonHoc;
use App\SinhVienLopHocPhan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\SinhVien;
use App\SinhVienBaiTap;
use Illuminate\Support\Facades\DB;

class LopHocPhanController extends Controller
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
        $lst_lhp = LopHocPhan::where('trangthai', '<>', 0)->with('lophoc')->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['status' => 'success', 'data' => $lst_lhp], 200);
    }

    public function getAll()
    {
        $lst_lhp = LopHocPhan::where('trangthai', '=', 1)->with('lophoc')->orderBy('id', 'DESC')->get();
        return response()->json(['status' => 'success', 'data' => $lst_lhp], 200);
    }


    public function lstLopHocPhanTheoGV($matk)
    {
        $id_giangvien = GiangVien::where('matk', $matk)->first()->id;
        $lst_lhp = LopHocPhan::where([['trangthai', '=', 1], ['magv', '=', $id_giangvien], ['luutru', '=', 0]])->with('giangvien', 'lophoc', 'monhoc')->withCount('sinhvienlophocphans')->get();
        return response()->json(['status' => 'success', 'data' => $lst_lhp], 200);
    }
    public function lstLopHocPhanTheoSV($id_sinhvien)
    {
        $sv = SinhVien::where('matk', $id_sinhvien)->first();
        $lst_lhp = LopHocPhan::where([['trangthai', '=', 1], ['luutru', '=', 0]])
            ->whereHas('sinhvienlophocphans', function (Builder $query) use ($sv) {
                $query->where('masv', '=', $sv->id);
            })->with('giangvien', 'lophoc', 'monhoc')->withCount('sinhvienlophocphans')->get();
        return response()->json(['status' => 'success', 'data' => $lst_lhp], 200);
    }

    public function lstLopHocPhanTheoAdmin()
    {
        $lst_lhp = LopHocPhan::where([['trangthai', '=', 1], ['luutru', '=', 0]])->with('giangvien', 'lophoc', 'monhoc')->withCount('sinhvienlophocphans')->get();
        return response()->json(['status' => 'success', 'data' => $lst_lhp], 200);
    }

    public function lstLopHocPhanLuuTruTheoGV($matk)
    {
        $id_giangvien = GiangVien::where('matk', $matk)->first()->id;
        $lst_lhp = LopHocPhan::where([['trangthai', '=', 1], ['magv', '=', $id_giangvien], ['luutru', '=', 1]])->with('giangvien', 'lophoc', 'monhoc')->withCount('sinhvienlophocphans')->get();
        return response()->json(['status' => 'success', 'data' => $lst_lhp], 200);
    }
    public function lstLopHocPhanLuuTruTheoSV($id_sinhvien)
    {
        $sv = SinhVien::where('matk', $id_sinhvien)->first();
        $lst_lhp = LopHocPhan::where([['trangthai', '=', 1], ['luutru', '=', 1]])
            ->whereHas('sinhvienlophocphans', function (Builder $query) use ($sv) {
                $query->where('masv', '=', $sv->id);
            })->with('giangvien', 'lophoc', 'monhoc')->withCount('sinhvienlophocphans')->get();
        return response()->json(['status' => 'success', 'data' => $lst_lhp], 200);
    }
    public function lstLopHocPhanLuuTruTheoAdmin()
    {

        $lst_lhp = LopHocPhan::where([['trangthai', '=', 1], ['luutru', '=', 1]])->with('giangvien', 'lophoc', 'monhoc')->withCount('sinhvienlophocphans')->get();
        return response()->json(['status' => 'success', 'data' => $lst_lhp], 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $id_lophoc = $request->malh;
        $id_monhoc = $request->mamh;
        $id_giangvien = $request->magv;

        $check_lhp = LopHocPhan::where([['malh', '=', $id_lophoc], ['mamh', '=', $id_monhoc]])->first();
        if (!empty($check_lhp)) {
            return response()->json(['status' => 'error', 'message' => 'Lớp học phần đã tồn tại'], 422);
        }

        $lophoc = LopHoc::find($id_lophoc);
        $monhoc = MonHoc::find($id_monhoc);

        $lhp = LopHocPhan::create([
            'tenlhp'    => $monhoc->tenmh . ' ' . $lophoc->tenlop,
            'ngaytao'   => Carbon::now()->toDateString(),
            'hocky'     => $request->hocky,
            'chinhsach' => $request->chinhsach,
            'namhoc'    => $request->namhoc,
            'magv'      => $id_giangvien,
            'malh'      => $id_lophoc,
            'mamh'      => $id_monhoc,
            'chinhsach' => 1,
            'trangthai' => 1
        ]);
        if ($lhp) {
            $lst_sv = SinhVien::where('malh', $lhp->malh)->get();
            foreach ($lst_sv as $sv) {
                SinhVienLopHocPhan::create([
                    'masv' => $sv->id,
                    'malhp' => $lhp->id,
                    'trangthai' => 1
                ]);
            }
            return response()->json(['status' => 'success', 'message' => 'Thêm lớp học phần thành công'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'Thêm lớp học phần không thành công'], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lhp = LopHocPhan::where('id', $id)->with('giangvien', 'lophoc', 'monhoc')->get();

        $data['lhp'] = $lhp[0];

        $sv_id = SinhVienLopHocPhan::where('malhp', $id)->where('trangthai', 1)->get()->pluck('masv');

        $lst_sv = SinhVien::whereIn('id', $sv_id)->with('sinhvienlophocphans', "lophoc")
            // )->with('sinhvienlophocphans')
            ->where('trangthai', 1)->get();
        $data['lst_sv'] = $lst_sv;

        $sv_lhp = SinhVienLopHocPhan::where('malhp', $id)->whereHas('sinhviens', function ($query) {
            $query->where('trangthai', 1);
        })->with('sinhviens')->get();
        $data['sv_lhp'] = $sv_lhp;
        if (!empty($lhp)) {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => $data
                ],
                200
            );
        }
        return response()->json(
            [
                'status' => 'error',
                'message' => 'Lớp học phần không tồn tại'
            ],
            404
        );
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
        $id_lophoc = $request->malh;
        $id_monhoc = $request->mamh;
        $id_giangvien = $request->magv;

        // $check_lhp = LopHocPhan::where([['malh', '=', $id_lophoc], ['mamh', '=', $id_monhoc]])->first();
        // if (!empty($check_lhp)) {
        //     return response()->json(['status' => 'error', 'message' => 'Lớp học phần đã tồn tại'], 422);
        // }

        $lophoc = LopHoc::find($id_lophoc);
        $monhoc = MonHoc::find($id_monhoc);

        $lhp = LopHocPhan::find($id);
        if ($lhp) {
            $lhp->tenlhp    = $monhoc->tenmh . ' ' . $lophoc->tenlop;
            $lhp->hocky    = $request->hocky;
            $lhp->namhoc    = $request->namhoc;
            $lhp->magv     = $id_giangvien;
            $lhp->malh      = $id_lophoc;
            $lhp->mamh      = $id_monhoc;
            $lhp->save();
            return response()->json(['status' => 'success', 'message' => 'Sửa thành công'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'Sửa không thành công'], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lhp = LopHocPhan::find($id);
        if (!empty($lhp)) {
            $lhp->trangthai = 0;
            $lhp->save();
            return response()->json(['status' => 'success', 'message' => 'Xóa lớp học phần thành công'], 200);
        } else
            return response()->json(['status' => 'error', 'message' => 'Lớp học phần không tồn tại'], 404);
    }
    public function lock(Request $request)
    {
        $lhp = LopHocPhan::find($request->id);
        $lhp->trangthai = 2;
        $lhp->save();
        // $lst_lhp = LopHocPhan::where('trangthai', 1)->get();
        $lst_lhp = LopHocPhan::where('trangthai', '<>', 0)->with('lophoc')->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['status' => 'success', 'message' => "Đã khóa", 'data' => $lst_lhp], 200);
    }
    public function unlock(Request $request)
    {
        $lhp = LopHocPhan::find($request->id);
        $lhp->trangthai = 1;
        $lhp->save();
        // $lst_lhp = LopHocPhan::where('trangthai', 2)->get();
        $lst_lhp = LopHocPhan::where('trangthai', '<>', 0)->with('lophoc')->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['status' => 'success', 'message' => "Đã mở khóa", 'data' => $lst_lhp], 200);
    }

    public function timkiemLHP(Request $request)
    {
        $data = LopHocPhan::where('trangthai', '<>', 0);

        if ($request->key_word != "null")
            $data = $data->where('tenlhp', 'like', '%' . $request->key_word . '%');
        if (intval($request->lophoc) != 0) {
            $data = $data->where('malh', intval($request->lophoc));
        }
        if (intval($request->hocky) != 0) {
            $data = $data->where('hocky', intval($request->hocky));
        }

        return response()->json(['status' => 'success', 'data' => $data->with('lophoc')->orderBy('id', 'DESC')->paginate(10)], 200);
    }
    public function themSV(Request $request, $id)
    {
        //id là id lhp 

        $sv_lhp = SinhVienLopHocPhan::where('masv', $request->sv_id)->where('malhp', $id)->first();
        if ($sv_lhp) return response()->json(['status' => 'error', 'message' => "Sinh viên đã có trong lớp học phần"]);

        SinhVienLopHocPhan::create([
            'masv' => $request->sv_id,
            'malhp' => $id,
            'trangthai' => 1
        ]);

        $lst_baiviet = BaiViet::where('loaibv', 2)->where('malhp', $id)->where('trangthai', 1)->pluck('id');
        foreach ($lst_baiviet as $baiviet) {
            SinhVienBaiTap::create([
                'mssv' => $request->sv_id,
                'mabv'  => $baiviet,
                'trangthai' => 0
            ]);
        }

        return response()->json(['status' => 'success', 'message' => "Thêm thành công"]);
    }
    public function khoaSV($id)
    {
        //id là id lhp 
        $sv_lhp = SinhVienLopHocPhan::where('id', $id)->first();
        $sv_lhp->trangthai = 2;
        $sv_lhp->save();
        return response()->json(['status' => 'success', 'message' => "Khóa thành công"]);
    }
    public function moSV($id)
    {
        //id là id lhp 
        $sv_lhp = SinhVienLopHocPhan::where('id', $id)->first();
        $sv_lhp->trangthai = 1;
        $sv_lhp->save();
        return response()->json(['status' => 'success', 'message' => "Đã mở khóa"]);
    }

    public function getLHPTheoDSLop(Request $request)
    {
        if ($request->malh == 0 && $request->hocky == 0) {
            $lst_lhp = LopHocPhan::where('trangthai', '<>', 0)->with('lophoc')->orderBy('id', 'DESC')->paginate(10);
            return response()->json(['status' => 'success', 'data' => $lst_lhp], 200);
        }

        if ($request->malh != 0 && $request->hocky != 0)
            $lst_lhp = LopHocPhan::where('trangthai', 1)->where('malh', $request->malh)->where('hocky', $request->hocky)->with('lophoc')->orderBy('id', 'DESC')->paginate(10);
        elseif ($request->malh != 0)
            $lst_lhp = LopHocPhan::where('trangthai', 1)->where('malh', $request->malh)->with('lophoc')->orderBy('id', 'DESC')->paginate(10);
        elseif ($request->hocky != 0)
            $lst_lhp = LopHocPhan::where('trangthai', 1)->where('hocky', $request->hocky)->with('lophoc')->orderBy('id', 'DESC')->paginate(10);

        return response()->json(['status' => 'success', 'data' => $lst_lhp], 200);
    }

    public function luuTru($id)
    {
        $lhp = LopHocPhan::where('id', $id)->first();
        $lhp->luutru = 1;
        $lhp->save();
        return response()->json(['status' => 'success', 'message' => 'Thành công'], 200);
    }

    public function khoiPhuc($id)
    {
        $lhp = LopHocPhan::where('id', $id)->first();
        $lhp->luutru = 0;
        $lhp->save();
        return response()->json(['status' => 'success', 'message' => 'Thành công'], 200);
    }
    public function thayDoiChinhSach(Request $request, $id)
    {
        $lophocphan = LopHocPhan::where('id', $id)->first();
        $lophocphan->chinhsach = $request->chinhsach;
        $lophocphan->save();
        return response()->json(['status' => 'success', 'message' => 'Thành công'], 200);
    }

    public function getChinhSachLopHocPhan($id)
    {
        $lhp = LopHocPhan::where('id', $id)->first();
        if (!empty($lhp)) {
            return response()->json(['status' => 'success', 'data' => $lhp->chinhsach]);
        } else
            return response()->json(['status' => 'error', 'message' => "Không tìm thấy lớp học phần"], 404);
    }
    public function locSVTheoLopHocPhan(Request $request, $id)
    {
        $lhp = LopHocPhan::where('id', $id)->with('giangvien', 'lophoc', 'monhoc')->get();


        $data['lhp'] = $lhp[0];

        $sv_id = SinhVienLopHocPhan::where('malhp', $id)->get()->pluck('masv');

        $malh_id = LopHocPhan::where('id', $id)->first()->malh;
        $lst_sv = SinhVien::whereIn('id', $sv_id)->with('sinhvienlophocphans', "lophoc");

        if ($request->hocghep == 1) {
            $sv_lhp = SinhVienLopHocPhan::where('malhp', $id)->whereHas('sinhviens', function (Builder $builder) use ($malh_id) {
                $builder->where("malh", '=', $malh_id);
            })->with('sinhviens')->get();
        }
        if ($request->hocghep == 2) {
            $sv_lhp = SinhVienLopHocPhan::where('malhp', $id)->whereHas('sinhviens', function (Builder $builder) use ($malh_id) {
                $builder->where("malh", '<>', $malh_id);
            })->with('sinhviens')->get();
        }

        $data['sv_lhp'] = $sv_lhp;
        if (!empty($lhp)) {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => $data
                ],
                200
            );
        }
        return response()->json(
            [
                'status' => 'error',
                'message' => 'Lớp học phần không tồn tại'
            ],
            404
        );
    }

    public function exportSV($id)
    {

        $sinhviens = SinhVien::whereHas('sinhvienlophocphans', function ($query) use ($id) {
            $query->where('malhp', '=', $id)->where('trangthai', 1);
        })->where('trangthai', 1)->select('id')->get()->toArray();

        return (new StudentExport($sinhviens))->download('Danh sách sinh viên.xlsx');
    }
}
