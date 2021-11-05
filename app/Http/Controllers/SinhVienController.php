<?php

namespace App\Http\Controllers;

use App\BaiViet;
use App\District;
use App\LopHoc;
use App\LopHocPhan;
use App\Province;
use Illuminate\Http\Request;
use App\SinhVien;
use App\SinhVienBaiTap;
use App\SinhVienLopHocPhan;
use App\User;
use App\Ward;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SinhVienController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function index()
    {
        $lst_sv = SinhVien::where('trangthai', '<>', 0)->with('lophoc')->orderBy('id', 'DESC')->paginate(10);

        if (!empty($lst_sv))
            return response()->json(['status' => 'success', 'data' => $lst_sv], 200);
    }

    public function getAll()
    {
        $lst_sv = SinhVien::where('trangthai', '<>', 0)->get();

        if (!empty($lst_sv))
            return response()->json(['status' => 'success', 'data' => $lst_sv], 200);
    }
    public function show(Request $request, $id)
    {
        $sv = SinhVien::where([['id', $id]])->with('lophoc', 'taikhoan')->first();
        if (!empty($sv))
            return response()->json(['status' => 'success', 'data' => $sv], 200);
    }
    public function store(Request $request)
    {

        $v = Validator::make($request->all(), [
            'mssv'          => 'required|unique:App\SinhVien,mssv',

        ], [
            'mssv.unique'             => 'Mã sinh viên bị trùng',
        ]);

        if ($v->fails()) {
            return response()->json(['status' => 'error', 'message' => $v->errors()->first()], 422);
        }

        $user = User::create([
            'email' => $request->mssv . '@caothang.edu.vn',
            'trangthai' => 1,
            'password'  => Hash::make($request->cccd)
        ]);
        if (!empty($user)) {
            $sv = SinhVien::create([
                'mssv'  => $request->mssv,
                'hosv' => $request->hosv,
                'tensv' => $request->tensv,
                'ngaysinh' => $request->ngaysinh,
                'gioitinh' => $request->gioitinh,
                'sdt' => $request->sdt,
                'cccd' => $request->cccd,
                'matk' => $user->id,
                'malh' => $request->lop,
                'diachi' => $request->diachi,
                'trangthai' => 1,
            ]);
            if (!empty($sv)) {
                return response()->json(['status' => 'success', 'message' => 'Thêm thành công', 'data' => $sv->id], 200);
            }
            return response()->json(['status' => 'error', 'message' => 'Thêm thất bại'], 403);
        }
    }
    public function update(Request $request, $id)
    {
        $sv = SinhVien::find($id);
        $sv->update([
            'hosv' => $request->hosv,
            'tensv' => $request->tensv,
            'ngaysinh' => $request->ngaysinh,
            'gioitinh' => $request->gioitinh,
            'sdt' => $request->sdt,
            'cccd' => $request->cccd,
            'malh' => $request->malop,
            'diachi' => $request->diachi,
        ]);
        if (!empty($sv)) {
            return response()->json(['status' => 'success', 'message' => 'Sửa thành công'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'Sửa thất bại'], 403);
    }
    public function destroy($id)
    {
        $sinhvien = SinhVien::find($id);
        if (!empty($sinhvien)) {
            if ($sinhvien->trangthai == 0) {
                return response()->json(['status' => 'error', 'message' => 'Sinh viên đã bị xóa'], 403);
            } else {
                $sinhvien->trangthai = 0;
                $sinhvien->save();
                return response()->json(['status' => 'success', 'message' => 'Xóa thành công'], 200);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Sinh viên không tồn tại'], 404);
        }
    }
    public function lock($id)
    {
        // $sinhvien = SinhVien::find($id);
        // if (!empty($sinhvien)) {
        //     if ($sinhvien->trangthai == 2) {
        //         return response()->json(['status' => 'error', 'message' => 'Sinh viên đã khóa'], 403);
        //     } else {
        //         $lst_sv = SinhVien::where('trangthai', '<>', 0)->paginate(10);
        //         $sinhvien->save();
        //         return response()->json(['status' => 'success', 'message' => 'Khóa thành công','data'=>$lst_sv], 200);
        //     }
        // } else {
        //     return response()->json(['status' => 'error', 'message' => 'Sinh viên không tồn tại'], 404);
        // }
        // return response()->json(['status' => 'success', 'message' => $id]);
        $sinhvien = SinhVien::where('id', $id)->first();

        $sinhvien->trangthai = 2;
        $sinhvien->save();
        // $lst_gv = GiangVien::where('trangthai', 1)->get();
        $lst_sv = SinhVien::where('trangthai', '<>', 0)->with('lophoc')->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['status' => 'success', 'message' => "Đã khóa", 'data' => $lst_sv], 200);
    }
    public function unlock($id)
    {
        // $sinhvien = SinhVien::find($id);
        // if (!empty($sinhvien)) {
        //     if ($sinhvien->trangthai == 1) {
        //         return response()->json(['status' => 'error', 'message' => 'Sinh viên không bị khóa'], 403);
        //     } else {
        //         $lst_sv = SinhVien::where('trangthai', '<>', 0)->paginate(10);
        //         $sinhvien->save();
        //         return response()->json(['status' => 'success', 'message' => 'Mở khóa thành công', 'data'=>$lst_sv], 200);
        //     }
        // } else {
        //     return response()->json(['status' => 'error', 'message' => 'Sinh viên không tồn tại'], 404);
        // }
        $sinhvien = SinhVien::find($id);
        $sinhvien->trangthai = 1;
        $sinhvien->save();
        // $lst_gv = GiangVien::where('trangthai', 2)->get();
        $lst_sv = SinhVien::where('trangthai', '<>', 0)->with('lophoc')->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['status' => 'success', 'message' => "Đã mở khóa", 'data' => $lst_sv], 200);
    }
    public function timkiemSV(Request $request)
    {
        
        $lst_sv = SinhVien::where('trangthai', '<>', 0);
        if ($request->key_word!= "null") {
            $lst_sv = $lst_sv->where('tensv', 'like', '%' . $request->key_word . '%'); 
        }
        if(intval($request->lop_hoc) != 0){
            
            $lst_sv = $lst_sv->where('malh',intval($request->lop_hoc));
        }
        return response()->json(['status' => 'success', 'data' => $lst_sv->with('lophoc')->orderBy('id', 'DESC')->paginate(10)]);
       

    }
    public function getThongTin($id)
    {
        $sv = SinhVien::where([['mssv', $id]])->with('lophoc')->first();
        if($sv)
        return response()->json(['status' => 'success', 'data' => $sv], 200);
        else 
        return response()->json(['status' => 'error'], 404);

    }


    public function importSinhVien(Request $request)
    {
        $user = User::create([
            'email' => $request->mssv . '@caothang.edu.vn',
            'trangthai' => 1,
            'password'  => Hash::make($request->cmnd)
        ]);

        if (!empty($user)) {

            $sv = SinhVien::create([
                'mssv'  => $request->mssv,
                'hosv' => $request->hosv,
                'tensv' => $request->tensv,
                'ngaysinh' => $request->ngaysinh,
                'gioitinh' => $request->gioitinh,
                'sdt' => $request->sdt,
                'cccd' => $request->cmnd,
                'matk' => $user->id,
                'malh' => $request->malh,
                'diachi' => $request->diachi,

                'trangthai' => 1,

            ]);
            if (!empty($sv)) {

                $lst_lhp = LopHocPhan::where('malh', $request->malh)->where('trangthai', 1)->pluck('id');

                if (!empty($lst_lhp)) {
                    foreach ($lst_lhp as $lhp) {
                        SinhVienLopHocPhan::create([
                            'masv' => $sv->id,
                            'malhp' => $lhp,
                            'trangthai' => 1
                        ]);

                        $lst_baiviet = BaiViet::where('loaibv', 2)->where('malhp', $lhp)->where('trangthai', 1)->pluck('id');
                        if (!empty($lst_baiviet)) {
                            foreach ($lst_baiviet as $baiviet) {
                                SinhVienBaiTap::create([
                                    'mssv' => $sv->id,
                                    'mabv'  => $baiviet,
                                    'trangthai' => 0
                                ]);
                            }
                        }
                    }
                }

                return response()->json(['status' => 'success', 'message' => 'Thêm thành công'], 200);
            }
            return response()->json(['status' => 'error', 'message' => 'Thêm thất bại'], 403);
        }
        return response()->json(['status' => 'error', 'message' => 'Thêm thất bại'], 403);
    }

    public function countSinhVienByKhoa()
    {
        $data= [];
        $y = date('Y');
        $m = date('m');
        if($m< 8) $y--;
        $dem = 0;
        do{
            $sv_khoa = DB::table('lop_hocs')
            ->join("sinh_viens","sinh_viens.malh",'=','lop_hocs.id')
            ->where('lop_hocs.khoa','=',$y)
            ->selectRaw('lop_hocs.khoa,count(sinh_viens.id) as number_of_sinhvien')
            ->groupBy('lop_hocs.khoa')
            ->get();
            array_push($data,$sv_khoa);
            $y--;
            $dem++;
        }while($dem < 3);
        return response()->json(['status' => 'success', 'data'=>$data ]);
    }
    public function locSVTheoLop(Request $request){
        $lst_sv = SinhVien::where('trangthai', '<>', 0)->with('lophoc');
        if($request->lop_hoc != 0){
            $lst_sv = $lst_sv->where('malh','=',$request->lop_hoc);
        }
        return response()->json(['status' => 'success', 'data' => $lst_sv->orderBy('id', 'DESC')->paginate(10)]);
    }

}
