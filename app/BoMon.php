<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoMon extends Model
{
    protected $fillable = ['tenbm', 'ngaylap', 'trangthai'];
    public function khoa()
    {
        return $this->belongsTo('App\Khoa', 'makhoa', 'id');
    }
    public function lophocs()
    {
        return $this->hasMany('App\LopHoc', 'mabm', 'id');
    }
    public function giangviens()
    {
        return $this->hasMany('App\GiangVien', 'mabm', 'id');
    }
}
