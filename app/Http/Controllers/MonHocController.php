<?php

namespace App\Http\Controllers;

use App\MonHoc;
use Illuminate\Http\Request;

class MonHocController extends Controller
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
        $lst_monhoc = MonHoc::where('trangthai','<>',0)->with('bomon')->paginate(10);

        return response()->json(['status'=> 'success','data'=>$lst_monhoc],200);
    }

    public function getAll()
    {
        $lst_monhoc = MonHoc::where('trangthai','<>',0)->with('bomon')->get();

        return response()->json(['status'=> 'success','data'=>$lst_monhoc],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $monhoc = MonHoc::create([
            'tenmh' => $request->tenmh,
            'tinchi' => $request->tinchi,
            'trangthai' => 1,
            'mabm' => $request->mabm
        ]);

        if(!empty($monhoc)){
            return response()->json(['status' =>'success','message'=>'Thêm thành công'],200);
        }
        else
        return response()->json(['status' =>'failed','message'=>'Thêm thất bại'],403);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $monhoc = MonHoc::where([['id',$id]])->with('bomon')->first();
        if(!empty($monhoc)){
            return response()->json(['status' =>'success','data'=> $monhoc],200);
        }
        return response()->json(['status' =>'failed','message'=>'Không tìm thấy môn học'],404);
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
        $monhoc = MonHoc::find($id);
        if(!empty($monhoc)){
            $monhoc->update([
                'tenmh' => $request->tenmh,
                'tinchi' =>$request->tinchi,
                'mabm'  =>$request->mabm
            ]);
            return response()->json(['status' =>'success','message'=>'Sửa thành công'],200);
        }
        return response()->json(['status' =>'failed','message'=>'Không tìm thấy môn học'],404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $monhoc = MonHoc::find($id);
        if(!empty($monhoc)){
            $monhoc->trangthai = 0;
            $monhoc->save();
            return response()->json(['status' =>'success','message'=>'Xóa thành công'],200);
        }
        else 
        return response()->json(['status' =>'failed','message'=>'Không tìm thấy môn học'],404);
    }

    public function timkiemMH(Request $request){
        if($request->key_word == null){
            $lst_sv = MonHoc::where('trangthai', '<>', 0)->with('bomon')->paginate(10);
            if (!empty($lst_sv))
                return response()->json(['status' => 'success', 'data' => $lst_sv], 200);
        }
        else{
            $lst_sv = MonHoc::where([['tenmh','like','%'.$request->key_word.'%'],['trangthai','<>',0]])->with('bomon')->paginate(10);
            if (!empty($lst_sv))
                return response()->json(['status' => 'success', 'data' => $lst_sv], 200);
        }
    }
}
