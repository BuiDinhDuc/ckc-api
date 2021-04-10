<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoMon extends Model
{
    protected $fillable = ['mabm', 'tenbm', 'ngaylap', 'trangthai'];
    protected $primaryKey = 'mabm';
    public function khoa()
    {
        return $this->belongsTo('App\Khoa', 'makhoa', 'makhoa');
    }
    public function lophocs()
    {
        return $this->hasMany('App\LopHoc', 'mabm', 'mabm');
    }
    public function giangviens()
    {
        return $this->hasMany('App\GiangVien', 'mabm', 'mabm');
    }
}
