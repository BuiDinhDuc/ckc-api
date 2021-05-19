<?php

namespace App\Http\Controllers;

use App\LopHoc;
use App\LopHocPhan;
use App\MonHoc;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LopHocPhanController extends Controller
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


    public function index()
    {
        $lst_lhp = LopHocPhan::where('trangthai', '=', 1)->get();
        return response()->json(['status' => 'success', 'data' => $lst_lhp], 200);
    }

    public function lstLopHocPhanTheoGV(Request $request)
    {
        $id_giangvien = $request->id_giangvien;
        $lst_lhp = LopHocPhan::where([['trangthai', '=', 1], ['magv', '=', $id_giangvien]])->get();
        return response()->json(['status' => 'success', 'data' => $lst_lhp], 200);
    }
    public function lstLopHocPhanTheoSV(Request $request)
    {
        $id_sinhvien = $request->id_sinhvien;
        $lst_lhp = LopHocPhan::where('trangthai', '=', 1)
            ->whereHas('sinhvienlophocphans', function (Builder $query) use ($id_sinhvien) {
                $query->where('masv', '=', $id_sinhvien);
            });
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
            'ngaytao'   => Carbon::now(),
            'hocky'     => $request->hocky,
            'chinhsach' => $request->chinhsach,
            'namhoc'    => $request->namhoc,
            'magv'      => $id_giangvien,
            'malh'      => $id_lophoc,
            'mamh'      => $id_monhoc,
            'trangthai' => 1
        ]);
        if ($lhp) {
            return response()->json(['status' => 'success', 'message' => 'Tạo lớp học phần thành công'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'Tạo lớp học phần không thành công'], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lhp = LopHocPhan::find($id)->with('giangvien', 'lophoc', 'monhoc')->get();
        if (!empty($lhp)) {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => $lhp
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

        $check_lhp = LopHocPhan::where([['malh', '=', $id_lophoc], ['mamh', '=', $id_monhoc]])->first();
        if (!empty($check_lhp)) {
            return response()->json(['status' => 'error', 'message' => 'Lớp học phần đã tồn tại'], 422);
        }

        $lophoc = LopHoc::find($id_lophoc);
        $monhoc = MonHoc::find($id_monhoc);

        $lhp = LopHocPhan::find($id);
        if ($lhp) {
            $lhp->tenlhp    = $monhoc->tenmh . ' ' . $lophoc->tenlop;
            $lhp->hocky    = $request->hocky;
            $lhp->chinhsach = $request->chinhsach;
            $lhp->namhoc    = $request->namhoc;
            $lhp->magv     = $id_giangvien;
            $lhp->malh      = $id_lophoc;
            $lhp->mamh      = $id_monhoc;
            $lhp->save();
            return response()->json(['status' => 'success', 'message' => 'Thành công'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'Không thành công'], 422);
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
}
