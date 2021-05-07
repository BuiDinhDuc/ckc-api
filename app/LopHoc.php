<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LopHoc extends Model
{
    protected $fillable = ['tenlop', 'ngaytao', 'trangthai', 'mabm'];
    public function bomon()
    {
        return $this->belongsTo('App\BoMon', 'mabm', 'mabm');
    }
    public function sinhviens()
    {
        return $this->hasMany('App\SinhVien', 'malh', 'id');
    }
    public function lophocphans()
    {
        return $this->hasMany('App\SinhVien', 'malh', 'id');
    }
}
