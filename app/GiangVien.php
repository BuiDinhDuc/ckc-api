<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiangVien extends Model
{
    protected $fillable = ['tengv', 'ngaysinh', 'diachi', 'sdt', 'email', 'matk', 'mabm'];
    public function taikhoan()
    {
        return $this->belongsTo('App\User', 'matk', 'matk');
    }
    public function bomon()
    {
        return $this->belongsTo('App\BoMon', 'mabm', 'mabm');
    }
    public function lophocphans()
    {
        return $this->hasMany('App\LopHocPhan', 'magv', 'id');
    }
    public function tinh()
    {
        return $this->hasOne('App\Province', 'id', 'province_id');
    }
    public function huyen()
    {
        return $this->hasOne('App\District', 'id', 'district_id');
    }
    public function xa()
    {
        return $this->hasOne('App\Ward', 'id', 'ward_id');
    }
}
