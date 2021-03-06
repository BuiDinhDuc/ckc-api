<?php

namespace App\Http\Controllers;

use App\BoMon;
use App\District;
use App\GiangVien;
use App\LopHoc;
use App\MonHoc;
use App\Province;
use App\User;
use App\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GiangVienController extends Controller
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
        $lst_giangvien = GiangVien::where('trangthai', '<>', 0)->with('bomon')->orderBy('id', 'DESC')->paginate(10);

        return response()->json(['status' => 'success', 'data' => $lst_giangvien], 200);
    }

    public function getAll()
    {
        $lst_giangvien = GiangVien::where('trangthai', '<>', 0)->get();

        return response()->json(['status' => 'success', 'data' => $lst_giangvien], 200);
    }
    public function getListGVByBoMon(Request $request)
    {
        // return response()->json(['status' => 'success', 'mabm' => $request->mabm,'khoa'=>$request->khoa], 200);

        $lst_lophoc = LopHoc::where('trangthai', 1);
        $lst_giangvien = GiangVien::where('trangthai', 1);
        $lst_monhoc = MonHoc::where('trangthai', 1);

        if (intval($request->mabm) != 0) {
            $lst_lophoc = $lst_lophoc->where('mabm', intval($request->mabm));
            $lst_giangvien =   $lst_giangvien->where('mabm', intval($request->mabm));
            $lst_monhoc = $lst_monhoc->where('mabm', intval($request->mabm));
        }
        if (intval($request->khoa) != 0) {
            $lst_lophoc->where('khoa', intval($request->khoa));
        }

        $data['lst_giangvien'] = $lst_giangvien->get();
        $data['lst_monhoc'] = $lst_monhoc->get();
        $data['lst_lophoc'] = $lst_lophoc->get();

        return response()->json(['status' => 'success', 'data' => $data], 200);
    }


    public function store(Request $request)
    {

        $v = Validator::make($request->all(), [
            'msgv'          => 'required|unique:App\GiangVien,msgv',

        ], [
            'msgv.unique'             => 'M?? gi??o vi??n b??? tr??ng',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'code'   => 422,
                'message' => $v->errors()->first(),
            ], 422);
        }
        $user = User::create([
            'email' => $request->msgv . '@caothang.edu.vn',
            'trangthai' => 1,
            'password'  => Hash::make($request->cccd),
            'role'      => 1
        ]);

        if (!empty($user)) {
            $gv = GiangVien::create([
                'msgv'  => $request->msgv,
                'hogv' => $request->hogv,
                'tengv' => $request->tengv,
                'ngaysinh' => $request->ngaysinh,
                'gioitinh' => $request->gioitinh,
                'sdt' => $request->sdt,
                'cccd' => $request->cccd,
                'matk' => $user->id,
                'mabm' => $request->bomon,
                'diachi' => $request->diachi,
                'trangthai' => 1,

            ]);
            if (!empty($gv)) {
                return response()->json(['status' => 'success', 'message' => 'Th??m th??nh c??ng', 'data' => $gv->id], 200);
            }
            return response()->json(['status' => 'error', 'message' => 'Th??m th???t b???i'], 403);
        }
    }


    public function show($id)
    {
        $sv = GiangVien::where('id', $id)->with('bomon', 'taikhoan', 'lophocphans')->first();
        if (!empty($sv))
            return response()->json(['status' => 'success', 'data' => $sv], 200);
    }

    public function update(Request $request, $id)
    {
        $gv = GiangVien::find($id);
        $gv->update([
            'hogv' => $request->hogv,
            'tengv' => $request->tengv,
            'ngaysinh' => $request->ngaysinh,
            'gioitinh' => $request->gioitinh,
            'sdt' => $request->sdt,
            'cccd' => $request->cccd,
            'mabm' => $request->bomon,
            'diachi' => $request->diachi,

        ]);
        if (!empty($gv)) {
            return response()->json(['status' => 'success', 'message' => 'S???a th??nh c??ng'], 200);
        }
        return response()->json(['status' => 'error', 'message' => 'S???a th???t b???i'], 403);
    }

    public function destroy($id)
    {
        $gv = GiangVien::find($id);
        if (!empty($gv)) {
            if ($gv->trangthai == 0) {
                return response()->json(['status' => 'error', 'message' => 'Gi???ng vi??n ???? b??? x??a'], 403);
            } else {
                $gv->trangthai = 0;
                $gv->save();
                return response()->json(['status' => 'success', 'message' => 'X??a th??nh c??ng'], 200);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Gi???ng vi??n kh??ng t???n t???i'], 404);
        }
    }
    public function lock(Request $request)
    {
        $gv = GiangVien::find($request->id);
        $gv->trangthai = 2;
        $gv->save();

        $user = User::whereHas('giangvien', function ($query) use ($request) {
            $query->where('id', $request->id);
        })->first();
        $user->trangthai = 2;
        $user->save();
        // $lst_gv = GiangVien::where('trangthai', 1)->get();
        $lst_giangvien = GiangVien::where('trangthai', '<>', 0)->with('bomon')->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['status' => 'success', 'message' => "???? kh??a", 'data' => $lst_giangvien], 200);
    }
    public function unlock(Request $request)
    {
        $gv = GiangVien::find($request->id);
        $gv->trangthai = 1;
        $gv->save();
        $user = User::whereHas('giangvien', function ($query) use ($request) {
            $query->where('id', $request->id);
        })->first();
        $user->trangthai = 1;
        $user->save();
        // $lst_gv = GiangVien::where('trangthai', 2)->get();
        $lst_giangvien = GiangVien::where('trangthai', '<>', 0)->with('bomon')->orderBy('id', 'DESC')->paginate(10);
        return response()->json(['status' => 'success', 'message' => "???? m??? kh??a", 'data' => $lst_giangvien], 200);
    }
    public function timkiemGV(Request $request)
    {
        if ($request->key_word == null) {
            $lst_gv = GiangVien::where('trangthai', '<>', 0)->with('bomon')->orderBy('id', 'DESC')->paginate(10);
            if (!empty($lst_gv))
                return response()->json(['status' => 'success', 'data' => $lst_gv], 200);
        } else {
            $lst_gv = GiangVien::where('hogv', 'like', '%' . $request->key_word . '%')
                ->orWhere('tengv', 'like', '%' . $request->key_word . '%');
            if (!empty($lst_gv))
                return response()->json(['status' => 'success', 'data' => $lst_gv->where('trangthai', '<>', 0)->with('bomon')->orderBy('id', 'DESC')->paginate(10)], 200);
        }
    }

    public function importGiangVien(Request $request)
    {
        $user = User::create([
            'email' => $request->msgv . '@caothang.edu.vn',
            'trangthai' => 1,
            'password'  => Hash::make($request->cmnd),
            'role'      => 1
        ]);

        if (!empty($user)) {

            $gv = GiangVien::create([
                'msgv'  => $request->msgv,
                'hogv' => $request->hogv,
                'tengv' => $request->tengv,
                'ngaysinh' => $request->ngaysinh,
                'gioitinh' => $request->gioitinh,
                'sdt' => $request->sdt,
                'cccd' => $request->cmnd,
                'matk' => $user->id,
                'mabm' => $request->mabm,
                'diachi' => $request->diachi,
                'trangthai' => 1,

            ]);
            if (!empty($gv)) {
                return response()->json(['status' => 'success', 'message' => 'Th??m th??nh c??ng'], 200);
            }
            return response()->json(['status' => 'error', 'message' => 'Th??m th???t b???i'], 403);
        }
    }
}
