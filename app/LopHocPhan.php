<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LopHocPhan extends Model
{
    protected $fillable = ['tenlhp', 'ngaytao', 'hocky', 'trangthai', 'magv', 'mabm', 'malh', 'mamh', 'chinhsach'];
    public function lophoc()
    {
        return $this->belongsTo('App\LopHoc', 'malh', 'malh');
    }
    public function monhoc()
    {
        return $this->belongsTo('App\MonHoc', 'mamh', 'mamh');
    }
    public function giangvien()
    {
        return $this->belongsTo('App\GiangVien', 'magv', 'magv');
    }
    public function chudes()
    {
        return $this->hasMany('App\ChuDe', 'malhp', 'id');
    }
    public function baiviets()
    {
        return $this->hasMany('App\BaiViet', 'malhp', 'id');
    }
    public function sinhvienlophocphans()
    {
        return $this->hasMany('App\SinhVienLopHocPhan', 'malhp', 'id');
    }
}
