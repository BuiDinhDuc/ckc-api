<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use App\SinhVien;
class StudentExport implements FromQuery
{
    use Exportable;
    protected $id;
    public function __construct($students)
    {
        $this->students = $students;
    }

    public function query()
    {
       

        return SinhVien::query()->whereKey($this->students)->select('mssv','hosv','tensv')->orderBy('mssv', 'ASC');
    }
}
