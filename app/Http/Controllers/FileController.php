<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use Carbon\Carbon;

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
        $lst_file = File::where('matk', $id_account)->get();
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
            $file = $request->file;
            $name_file = $file->getClientOriginalName();
            $size = $file->getSize();
            $path = public_path('document/' . $id_account);
            $file->move($path, $name_file);

            $child = File::create([
                'tenfile' => $name_file,
                'path' => '/' . $id_account . '/',
                'dungluong' => $size,
                'duoifile' => '.' . $file->getClientOriginalExtension(),
                'trangthai' => 1,
                'matk' => $id_account,
                'ngaytao' => Carbon::now()->toDateString()
            ]);

            $lst_file = File::where('matk', $id_account)->get();
            return response()->json(['status' => 'success', 'message' => 'Upload thành công', 'data' => $lst_file]);
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
}
