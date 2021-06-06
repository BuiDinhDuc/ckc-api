<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SinhVienLopHocPhan extends Model
{
    protected $fillable = ['masv', 'malhp', 'trangthai'];

    public function sinhvien(){
        return $this->hasOne('App\SinhVien', 'masv', 'id');
    }
}
