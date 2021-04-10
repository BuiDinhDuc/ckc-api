<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LopHoc extends Model
{
    protected $fillable = ['malh', 'tenlop', 'ngaytao', 'trangthai', 'mabm'];
    protected $primaryKey = 'malh';
    public function bomon()
    {
        return $this->belongsTo('App\BoMon', 'mabm', 'mabm');
    }
    public function sinhviens()
    {
        return $this->hasMany('App\SinhVien', 'malh', 'malh');
    }
    public function lophocphans()
    {
        return $this->hasMany('App\SinhVien', 'malh', 'malh');
    }
}
