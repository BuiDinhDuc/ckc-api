<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use App\SinhVienBaiTap;
use Illuminate\Support\Facades\DB;
class StudentScoreExport implements FromQuery
{
    use Exportable;
    protected $id;
    public function __construct($students)
    {
        $this->students = $students;
       
    }

    public function query()
    {
        // return SinhVienBaiTap::query()->whereKey($this->students)->with('sinhvien')->select('mssv','sinhvien.hosv')->orderBy('mssv', 'ASC');
        return DB::table('sinh_vien_bai_taps')
        ->join('sinh_viens','sinh_viens.id','sinh_vien_bai_taps.mssv')
        ->whereIn('sinh_vien_bai_taps.id',$this->students)
        ->where("sinh_viens.trangthai",1)
        ->select('sinh_viens.mssv','sinh_viens.hosv','sinh_viens.tensv','diem')
        ->orderBy('sinh_viens.mssv', 'ASC');
    }
}
