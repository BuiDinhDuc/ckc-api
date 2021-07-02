<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SinhVienBaiTap extends Model
{
    protected $fillable = ['mssv', 'mabv', 'trangthai'];

    public function sinhvien()
    {
        return $this->belongsTo('App\SinhVien', 'mssv', 'id');
    }
}
