<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    protected $fillable = ['noidung', 'ngaytao', 'mabv', 'matk', 'trangthai'];

    public function baiviet()
    {
        return $this->belongsTo('App\BaiViet', 'mabv', 'mabv');
    }
    public function taikhoan()
    {
        return $this->belongsTo('App\User', 'matk', 'matk');
    }
}
