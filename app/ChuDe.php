<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChuDe extends Model
{
    protected $fillable = ['macd', 'tencd', 'thutu', 'trangthai', 'malhp'];
    protected $primaryKey = 'macd';

    public function lophocphan()
    {
        return $this->belongsTo('App\LopHocPhan', 'malhp', 'malhp');
    }
    public function baiviets()
    {
        return $this->hasMany('App\BaiViet', 'macd', 'macd');
    }
}
