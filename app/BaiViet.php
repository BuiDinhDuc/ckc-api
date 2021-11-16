<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    protected $fillable = ['tieude', 'noidung', 'ngaytao', 'loaibv', 'matk', 'malhp', 'trangthai', 'macd', 'ngayketthuc', 'gioketthuc'];


    public function chude()
    {
        return $this->belongsTo('App\ChuDe', 'macd', 'id');
    }
    public function binhluans()
    {
        return $this->hasMany('App\BinhLuan', 'mabv', 'id')->where('trangthai', 1)->with('taikhoan')->orderBy('id', 'DESC');
    }
    public function lophocphan()
    {
        return $this->belongsTo('App\LopHocPhan', 'malhp', 'id');
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
    public function filebaiviets()
    {
        return $this->hasMany('App\FileBaiViet', 'mabv', 'id')->where('trangthai', 1)->with('file');
    }

    public function giaobai()
    {
        return $this->hasMany('App\SinhVienBaiTap', 'mabv', 'id');
    }
    public function binhchonco(){
        return $this->hasMany('App\BinhChon','mabv', 'id')->where('binh_chon',1);
    }
    public function binhchonkhong(){
        return $this->hasMany('App\BinhChon','mabv', 'id')->where('binh_chon', 0);
    }
}
