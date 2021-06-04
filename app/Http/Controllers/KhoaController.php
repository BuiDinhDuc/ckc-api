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
    public function detailKhoa($id)
    {
        $khoa = Khoa::find($id);
        if (!empty($khoa))
            return response()->json(['status' => 'success', 'data' => $khoa], 200);
        else
            return response()->json(['status' => 'failed', 'message' => 'Không tìm thấy khoa'], 200);
    }
    public function createNewKhoa(Request $request)
    {
        $khoa = new Khoa();
        $khoa->tenkhoa = $request->tenkhoa;
        // $khoa->ngaylap  = $request->ngaylap;
        $khoa->trangthai  = 1;
        $khoa->save();
        $lst_khoa = Khoa::where('trangthai', 1)->get();
        return response()->json(['status' => 'success', 'data' => $lst_khoa], 200);
    }
    public function updateKhoa(Request $request,$id)
    {
        $khoa = Khoa::find($id);
        if (!empty($khoa)) {
            $khoa->tenkhoa      = $request->tenkhoa;
            // $khoa->ngaylap      = $request->ngaylap;
            $khoa->trangthai    = 1;
            $khoa->save();
            $lst_khoa = Khoa::where('trangthai', 1)->get();
            return response()->json(['status' => 'success', 'data' => $lst_khoa], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Không tìm thấy khoa'], 404);
        }
    }
    public function deleteKhoa($id)
    {
        $khoa = Khoa::find($id);
        if (!empty($khoa)) {
            $khoa->trangthai  = 0;
            $khoa->save();
            return response()->json(['status' => 'success', 'message' => 'Xóa thành công'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Không thể xóa khoa vì có bộ môn'], 404);
        }
    }
 
}
