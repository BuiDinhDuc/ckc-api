<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChuDe extends Model
{
    protected $fillable = ['tencd', 'thutu', 'trangthai', 'malhp'];


    public function lophocphan()
    {
        return $this->belongsTo('App\LopHocPhan', 'malhp', 'malhp');
    }
    public function baitaps()
    {
        return $this->hasMany('App\BaiViet', 'macd', 'id');
    }
}
