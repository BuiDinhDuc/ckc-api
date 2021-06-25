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
    public function baitapscochude()
    {
        return $this->hasMany('App\BaiViet', 'macd', 'id')->where([
            ['loaibv', 2],
            ['trangthai', 1],
            ['macd', '<>', 0]
        ]);
    }
}
