<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SinhVien extends Model
{
    protected $fillable = ['hosv', 'tensv', 'ngaysinh', 'gioitinh', 'diachi', 'sdt', 'cccd', 'matk', 'malh', 'mssv'];
    public function taikhoan()
    {
        return $this->belongsTo('App\User', 'matk', 'id');
    }
    public function lophoc()
    {
        return $this->hasOne('App\LopHoc', 'id', 'malh');
    }
    public function sinhvienlophocphans()
    {
        return $this->hasMany('App\SinhVienLopHocPhan', 'masv', 'id');
    }

    public function sinhvienbaiviets()
    {
        return $this->hasMany('App\SinhVienBaiTap', 'mssv', 'id');
    }
}
