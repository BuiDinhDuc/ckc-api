<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BangTin extends Model
{
    protected $fillable = ['noidung', 'mabv', 'magv', 'loaibangtin', 'ngaytao', 'trangthai', 'malhp'];

    public function giangvien()
    {
        return $this->belongsTo('App\GiangVien', 'magv', 'id');
    }
    public function baiviet()
    {
        return $this->hasOne('App\BaiViet', 'mabv', 'id');
    }
    public function lophocphan()
    {
        return $this->belongsTo('App\LopHocPhan', 'malhp', 'id');
    }
    public function file_bang_tin()
    {
        return $this->hasMany('App\FileBangTin', 'mabangtin', 'id')->with('file');
    }
    public function binhluans()
    {
        return $this->hasMany('App\BinhLuan', 'mabt', 'id')->where('trangthai', 1)->with('taikhoan')->orderBy('id', 'DESC');
    }
}
