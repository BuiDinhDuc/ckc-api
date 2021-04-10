<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    protected $fillable = ['mabl', 'noidung', 'ngaytao', 'mabv', 'matk', 'trangthai'];
    protected $primaryKey = 'mabl';

    public function baiviet()
    {
        return $this->belongsTo('App\BaiViet', 'mabv', 'mabv');
    }
    public function taikhoan()
    {
        return $this->belongsTo('App\User', 'matk', 'matk');
    }
}
