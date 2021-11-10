<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LopHocPhan extends Model
{
    protected $fillable = ['tenlhp', 'ngaytao', 'hocky', 'namhoc', 'trangthai', 'magv', 'mabm', 'malh', 'mamh', 'chinhsach'];
    public function lophoc()
    {
        return $this->belongsTo('App\LopHoc', 'malh', 'id');
    }
    public function monhoc()
    {
        return $this->belongsTo('App\MonHoc', 'mamh', 'id');
    }
    public function giangvien()
    {
        return $this->belongsTo('App\GiangVien', 'magv', 'id');
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
        return $this->hasMany('App\SinhVienLopHocPhan', 'malhp', 'id')->where('trangthai', 1);
    }
}
