<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LopHoc extends Model
{
    protected $table="lop_hocs";
    protected $fillable = ['tenlop', 'ngaytao', 'trangthai', 'mabm'];
    public function bomon()
    {
        return $this->belongsTo('App\BoMon', 'mabm', 'id');
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
