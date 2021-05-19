<?php

namespace App\Http\Controllers;

use App\District;
use App\Province;
use App\Ward;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
   public function getProvince()
   {
       return response()->json(['data' => Province::all()]);
   }
   public function getDistrict(Request $request)
   {
       return response()->json(['data' => District::where('province_id',$request->province_id)->get()]);
   }
   public function getWard(Request $request)
   {
       return response()->json(['data' => Ward::where('district_id',$request->district_id)->get()]);
   }
}
