<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SinhVien extends Model
{
    protected $fillable = ['hosv','tensv', 'ngaysinh','gioitinh', 'diachi', 'sdt', 'cccd', 'matk', 'malh','province_id','district_id','ward_id','mssv'];
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
    public function tinh()
    {
        return $this->hasOne('App\Province', 'id', 'province_id');
    }
    public function huyen()
    {
        return $this->hasOne('App\District', 'id', 'district_id');
    }
    public function xa()
    {
        return $this->hasOne('App\Ward', 'id', 'ward_id');
    }
}
