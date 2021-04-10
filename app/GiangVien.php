<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiangVien extends Model
{
    protected $fillable = ['magv', 'tengv', 'ngaysinh', 'diachi', 'sdt', 'email', 'matk', 'mabm'];
    protected $primaryKey = 'magv';

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
        return $this->hasMany('App\LopHocPhan', 'magv', 'magv');
    }
}
