<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    protected $fillable = ['noidung', 'ngaytao', 'mabv', 'matk', 'trangthai', 'mabt'];

    public function baiviet()
    {
        return $this->belongsTo('App\BaiViet', 'mabv', 'mabv');
    }
    public function taikhoan()
    {
        return $this->belongsTo('App\User', 'matk', 'id')->with('giangvien', 'sinhvien');
    }
    public function giangvien()
    {
        return $this->belongsTo('App\GiangVien', 'matk', 'id');
    }
    public function sinhvien()
    {
        return $this->belongsTo('App\SinhVien', 'matk', 'id');
    }
}
