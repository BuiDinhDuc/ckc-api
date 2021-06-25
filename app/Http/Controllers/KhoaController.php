<?php

namespace App\Http\Controllers;

use App\Khoa;
use Illuminate\Http\Request;
use App\BoMon;

class KhoaController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $lst_khoa = Khoa::where('trangthai','<>',0)->withCount('bomons')->orderBy('id','DESC')->paginate(10);
        if (!empty($lst_khoa))
            return response()->json(['status' => 'success', 'data' => $lst_khoa], 200);
        else
            return response()->json(['status' => 'failed', 'message' => 'Không có khoa nào'], 404);
    }

    public function getAll()
    {
        $lst_khoa = Khoa::where('trangthai', 1)->get();
        if (!empty($lst_khoa))
            return response()->json(['status' => 'success', 'data' => $lst_khoa], 200);
        else
            return response()->json(['status' => 'failed', 'message' => 'Không có khoa nào'], 404);
    }

    public function show($id)
    {
        $khoa = Khoa::find($id);
        if (!empty($khoa))
            return response()->json(['status' => 'success', 'data' => $khoa], 200);
        else
            return response()->json(['status' => 'failed', 'message' => 'Không tìm thấy khoa'], 200);
    }
    public function store(Request $request)
    {
        $khoa = new Khoa();
        $khoa->tenkhoa = $request->tenkhoa;
        $khoa->trangthai  = 1;
        $khoa->save();
        return response()->json(['status' => 'success', 'message' => 'Thêm thành công','data'=>$khoa->id], 200);
    }
    public function update(Request $request,$id)
    {
        $khoa = Khoa::find($id);
        if (!empty($khoa)) {
            $khoa->tenkhoa      = $request->tenkhoa;
            // $khoa->ngaylap      = $request->ngaylap;
            $khoa->trangthai    = 1;
            $khoa->save();
            return response()->json(['status' => 'success', 'message' => 'Sửa thành công'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Không tìm thấy khoa'], 404);
        }
    }
    public function destroy($id)
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
    public function lock(Request $request)
    {
        
        $khoa = Khoa::find($request->id);
        $khoa->trangthai = 2;
        $khoa->save();
        // $lst_bomon = BoMon::where('trangthai', 1)->get();
        $lst_khoa = Khoa::where('trangthai','<>',0)->withCount('bomons')->orderBy('id','DESC')->paginate(10);
        return response()->json(['status' => 'success', 'message' => "Đã khóa",'data' => $lst_khoa], 200);
    }
    public function unlock(Request $request)
    {
        $khoa = Khoa::find($request->id);
        $khoa->trangthai = 1;
        $khoa->save();
        // $lst_bomon = BoMon::where('trangthai', 2)->get();
        $lst_khoa = Khoa::where('trangthai','<>',0)->withCount('bomons')->orderBy('id','DESC')->paginate(10);
        return response()->json(['status' => 'success', 'message' => "Đã mở khóa", 'data'=>$lst_khoa], 200);
    }
    public function timkiemKhoa(Request $request){
        if($request->key_word == null){
            $lst_khoa = Khoa::where('trangthai', '<>', 0)->withCount('bomons')->orderBy('id','DESC')->paginate(10);
            if (!empty($lst_khoa))
                return response()->json(['status' => 'success', 'data' => $lst_khoa], 200);
        }
        else{
            $lst_khoa = Khoa::where([['tenkhoa','like','%'.$request->key_word.'%'],['trangthai','<>',0]])->withCount('bomons')->orderBy('id','DESC')->paginate(10);
            if (!empty($lst_khoa))
                return response()->json(['status' => 'success', 'data' => $lst_khoa], 200);
        }
    }

}
