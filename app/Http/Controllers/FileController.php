<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class FileController extends Controller
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
    public function index($id_account)
    {
        $lst_file = File::where('matk', $id_account)->orderBy('ngaytao', 'DESC')->get();
        return response()->json(['status' => 'success', 'data' => $lst_file]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $id_account = $request->matk;
        if ($request->hasFile('file')) {
            $file        = $request->file;
            $name_file   = $file->getClientOriginalName();
            $file_name   = $request->tenfile;
            $size        = $file->getSize();
            $path        = public_path('document/' . $id_account);
            $file->move($path, $name_file);

            $child = File::create([
                'tenfile'       => $name_file,
                'path'          => 'document/' . $id_account . '/' . $name_file,
                'dungluong'     => $size,
                'duoifile'      => '.' . $file->getClientOriginalExtension(),
                'trangthai'     => 1,
                'matk'          => $id_account,
                'ngaytao'       => Carbon::now()->toDateTimeString(),
                'file_name'     => $file_name
            ]);

            $lst_file = File::where('matk', $id_account)->get();
            return response()->json(['status' => 'success', 'message' => 'Upload thành công', 'data' => $lst_file]);
        }
    }

    public function uploadFileBaiLam(Request $request)
    {

        $id_account = $request->matk;
        if ($request->hasFile('file')) {

            $file        = $request->file;
            $name_file   = $file->getClientOriginalName();
            $file_name   = $request->tenfile;
            $size        = $file->getSize();
            $path        = public_path('document/' . $id_account);
            $file->move($path, $name_file);

            $child = File::create([
                'tenfile'       => $name_file,
                'path'          => 'document/' . $id_account . '/' . $name_file,
                'dungluong'     => $size,
                'duoifile'      => '.' . $file->getClientOriginalExtension(),
                'trangthai'     => 1,
                'matk'          => $id_account,
                'ngaytao'       => Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString(),
                'file_name'     => $file_name
            ]);


            return response()->json(['status' => 'success', 'message' => 'Upload thành công', 'data' => $child->id]);
        }
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
        //
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

    public function uploadFileTaoDienDan(Request $request)
    {

        $lst_file_upload = array();
        $id_account = $request->matk;
        if ($request->hasFile('file')) {

            $file        = $request->file;
            $name_file   = $file->getClientOriginalName();
            $tenfile     = Carbon::now('Asia/Ho_Chi_Minh')->format('Y_m_d_H_i_s_u') . '.' . $file->getClientOriginalExtension();
            $size        = $file->getSize();
            $path        = public_path('document/' . $id_account);
            $file->move($path, $tenfile);

            $child = File::create([
                'tenfile'       => $name_file,
                'path'          => 'document/' . $id_account . '/' . $tenfile,
                'dungluong'     => $size,
                'duoifile'      => '.' . $file->getClientOriginalExtension(),
                'trangthai'     => 1,
                'matk'          => $id_account,
                'ngaytao'       => Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString(),
                'file_name'     => $tenfile
            ]);


            return response()->json(['status' => 'success', 'message' => 'Upload thành công', 'data' => $child->id]);
        }
    }
}
