<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    protected $fillable = ['mabv', 'tieude', 'noidung', 'ngaytao', 'loaibv', 'matk', 'malhp', 'trangthai', 'macd'];
    protected $primaryKey = 'mabv';

    public function chude()
    {
        return $this->belongsTo('App\ChuDe', 'macd', 'macd');
    }

    public function binhluans()
    {
        return $this->hasMany('App\BinhLuan');
    }
}
