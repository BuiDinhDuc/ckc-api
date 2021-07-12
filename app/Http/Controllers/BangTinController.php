<?php

namespace App\Http\Controllers;

use App\BangTin;
use App\FileBangTin;
use App\GiangVien;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BangTinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($malhp)
    {
        $lst_bangtin = BangTin::where('malhp', $malhp)->where('trangthai', 1)->with('giangvien', 'lophocphan', 'file_bang_tin')->orderBy('id', 'DESC')->get();
        return response()->json(['status' => 'success', 'data' => $lst_bangtin]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $magv = GiangVien::where('matk', $request->matk)->first()->id;

        $bangtin = BangTin::create([
            'noidung'       => $request->noidung,
            'magv'          => $magv,
            'loaibangtin'   => 1,
            'ngaytao'       => Carbon::now('Asia/Ho_Chi_Minh'),
            'trangthai'     => 1,
            'malhp'         => $request->malhp,
        ]);
        if (!empty($bangtin)) {
            if (!empty($request->dsFile)) {
                $dsFile = explode(',', $request->dsFile);
                foreach ($dsFile as $file) {
                    FileBangTin::create([
                        'mafile'    => $file,
                        'mabangtin' => $bangtin->id,
                        'trangthai' => 1
                    ]);
                }
            }
            return response()->json(['status' => 'success', 'message' => 'Thành công']);
        } else
            return response()->json(['status' => 'error', 'message' => "Không thành công"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $bangtin = BangTin::where('id', $id)->first();
        $bangtin->update([
            'noidung'       => $request->noidung,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
