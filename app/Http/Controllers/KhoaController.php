<?php

namespace App\Http\Controllers;

use App\Khoa;
use Illuminate\Http\Request;
use App\BoMon;

class KhoaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAllKhoa(Request $request)
    {
        $lst_khoa = Khoa::where('trangthai', 1)->get();
        if (!empty($lst_khoa))
            return response()->json(['status' => 'success', 'data' => $lst_khoa], 200);
        else
            return response()->json(['status' => 'failed', 'message' => 'Không có khoa nào'], 404);
    }
    public function detailKhoa(Request $request)
    {
        $khoa = Khoa::where('makhoa', $request->makhoa)->get();
        if (!empty($khoa))
            return response()->json(['status' => 'success', 'data' => $khoa], 200);
        else
            return response()->json(['status' => 'failed', 'message' => 'Không tìm thấy khoa'], 200);
    }
    public function createNewKhoa(Request $request)
    {
        $khoa = new Khoa();
        $makhoa =  $this->taoma();
        $khoa->makhoa  = $makhoa;
        $khoa->tenkhoa = $request->tenkhoa;
        $khoa->ngaylap  = $request->ngaylap;
        $khoa->trangthai  = 1;
        $khoa->save();
        $lst_khoa = Khoa::where('trangthai', 1)->get();
        return response()->json(['status' => 'success', 'data' => $lst_khoa], 200);
    }
    public function updateKhoa(Request $request)
    {
        $khoa = Khoa::find($request->makhoa);
        if (!empty($khoa)) {
            $khoa->tenkhoa      = $request->tenkhoa;
            $khoa->ngaylap      = $request->ngaylap;
            $khoa->trangthai    = 1;
            $khoa->save();
            $lst_khoa = Khoa::where('trangthai', 1)->get();
            return response()->json(['status' => 'success', 'data' => $lst_khoa], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Không tìm thấy khoa'], 404);
        }
    }
    public function deleteKhoa(Request $request)
    {
        $khoa = Khoa::where('makhoa', '=', $request->makhoa)->first();
        $bomon = BoMon::where('makhoa', '=', $request->makhoa);
        if (empty($bomon)) {
            $khoa->trangthai  = 1;
            $khoa->save();
            $lst_khoa = Khoa::where('trangthai', 1)->get();
            return response()->json(['status' => 'success', 'data' => $lst_khoa], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Không thể xóa khoa vì có bộ môn'], 404);
        }
    }
    function taoma()
    {
        $makhoa =  Khoa::count() + 1;
        if ($makhoa < 10) $makhoa = '0' . $makhoa;
        return $makhoa;
    }
}
