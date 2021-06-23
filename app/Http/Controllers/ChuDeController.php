<?php

namespace App\Http\Controllers;

use App\ChuDe;
use App\LopHocPhan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChuDeController extends Controller
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

    public function index(Request $request)
    {
        $lhp = $request->header('id');
        $lst_chude = ChuDe::where([
            ['trangthai', 1],
            ['malhp', $lhp]
        ])->whereHas('baiviet', function ($query) {
            $query->orderBy('macd');
        })->orderBy('thutu', 'desc')->get();
    }

    public function getAllChuDeTheoLHP($malhp)
    {
        $lst_chude = ChuDe::where([
            ['trangthai', 1],
            ['malhp', $malhp]
        ])
            ->orderBy('thutu', 'ASC')->get();

        return response()->json(['status' => 'Success', 'data' => $lst_chude], 200);
    }
    public function getBaiTapTheoChuDe($malhp)
    {
        $lst_chude = ChuDe::where([
            ['trangthai', 1],
            ['malhp', $malhp]
        ])->with('baitaps')
            ->orderBy('thutu', 'ASC');

        return response()->json(['status' => 'Success', 'data' => $lst_chude], 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make(
            $request->all(),
            ['tencd' => 'required'],
            ['tencd.required' => 'Tên chủ đề không được bỏ trống']
        );

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'code'   => 422,
                'message' => $v->errors()->first(),
            ], 422);
        }

        $malhp = $request->malhp;
        $lhp = LopHocPhan::find($malhp);
        if (!empty($lhp)) {
            $chude = ChuDe::where([['malhp', '=', $malhp], ['tencd', '=', $request->tencd]])->first();
            if (empty($chude)) {
                ChuDe::create([
                    'malhp' => $malhp,
                    'tencd' => $request->tencd,
                    'thutu' => 1,
                    'trangthai' => 1
                ]);
                $lst_chude = ChuDe::where([
                    ['trangthai', 1],
                    ['malhp', $malhp]
                ])->with('baitaps')
                    ->orderBy('thutu', 'ASC')->get();
                return response()->json(['status' => 'success', 'message' => "Tạo chủ đề thành công", 'data' => $lst_chude], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => "Chủ đề đã tồn tại trong lớp học phần"], 422);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => "Lớp học phần không tồn tại"], 404);
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
        $lst_chude = ChuDe::find($id)->whereHas('baiviet', function ($query) {
            $query->orderBy('macd');
        })->orderBy('thutu', 'desc')->get();
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
        $v = Validator::make(
            $request->all(),
            ['tencd' => 'required'],
            ['tencd.required' => 'Tên chủ đề không được bỏ trống']
        );

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'code'   => 422,
                'message' => $v->errors()->first(),
            ], 422);
        }

        $chude = ChuDe::find($id);
        if (!empty($chude)) {
            $cd  = ChuDe::where([['malhp', '=', $request->malhp], ['tencd', '=', $request->tencd]])->first();
            if (empty($cd)) {
                $chude->tencd = $request->tencd;
                $chude->malhp = $request->malhp;
                $chude->thutu = $request->thutu;

                $chude->save();
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy chủ đề'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chude = ChuDe::find($id);
        if (!empty($chude)) {
            $chude->trangthai = 0;
            $chude->save();
            return response()->json(['status' => 'success', 'message' => 'Xóa chủ đề thành công'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy chủ đề'], 404);
        }
    }
}
