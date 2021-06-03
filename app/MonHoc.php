<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonHoc extends Model
{
    protected $fillable = ['tenmh', 'tinchi', 'trangthai','mabm'];
    public function lophocphans()
    {
        return $this->hasMany('App\LopHocPhan', 'mamh', 'id');
    }
    public function bomon()
    {
        return $this->belongsTo('App\BoMon', 'mabm', 'id');
    }
}
