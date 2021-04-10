<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SinhVien extends Model
{
    protected $fillable = ['masv', 'tensv', 'ngaysinh', 'diachi', 'sdt', 'email', 'matk', 'mabm', 'malh'];
    protected $primaryKey = 'masv';
    public function taikhoan()
    {
        return $this->belongsTo('App\User', 'matk', 'matk');
    }
    public function lophoc()
    {
        return $this->belongsTo('App\LopHoc', 'malh', 'malh');
    }
    public function sinhvienlophocphans()
    {
        return $this->hasMany('App\SinhVienLopHocPhan', 'masv', 'masv');
    }
}
