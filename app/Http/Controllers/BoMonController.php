<?php

namespace App\Http\Controllers;

use App\BoMon;
use Illuminate\Http\Request;

class BoMonController extends Controller
{
    public function getAll(Request $request){
        $lst_bomon = BoMon::where('trangthai',1)->with('bm')->get();
        return response()->json(['status'=>'success','data'=>$lst_bomon],200);
    }
    public function detail(Request $request){
        $bomon = BoMon::where('mabm',$request->mabm)->with('bm')->get();
        return response()->json(['status'=>'success','data'=>$bomon],200);
    }
    public function createNew(Request $request){
        $bomon = new BoMon();
        $mabm =  $this->taoma();
        $bomon->mabm  = $mabm;
        $bomon->tenbm = $request->tenbm;
        $bomon->ngaylap  = $request->ngaylap;
        $bomon->trangthai  = 1;
        $bomon->mabm = $request->mabm;
        $bomon->save();
        $lst_bomon = BoMon::where('trangthai',1)->get();
        return response()->json(['status'=>'success','data'=>$lst_bomon],200);
    }
    public function update(Request $request){
        $bomon = BoMon::find($request->mabm);
        $bomon->tenbm = $request->tenbm;
        $bomon->ngaylap  = $request->ngaylap;
        $bomon->trangthai  = 1;
        $bomon->makhoa = $request->makhoa;
        $bomon->save();
        $lst_bomon = BoMon::where('trangthai',1)->get();
        return response()->json(['status'=>'success','data'=>$lst_bomon],200);
    }
    public function delete(Request $request){
        $bomon = BoMon::find($request->mabm);
        $bomon->trangthai = 0;
        $bomon->save();
        $lst_bomon = BoMon::where('trangthai',1)->get();
        return response()->json(['status'=>'success','data'=>$lst_bomon],200);
    }
    function taoma(){
        $mabm =  BoMon::count() + 1;
        if($mabm < 10) $mabm = '0'.$mabm;
        return $mabm;
    }
}
