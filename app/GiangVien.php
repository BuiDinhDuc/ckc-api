<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiangVien extends Model
{
    protected $fillable = ['tengv', 'hogv', 'ngaysinh', 'diachi', 'sdt', 'email', 'matk', 'mabm', 'gioitinh', 'cccd',  'msgv'];
    public function taikhoan()
    {
        return $this->belongsTo('App\User', 'matk', 'id');
    }
    public function bomon()
    {
        return $this->belongsTo('App\BoMon', 'mabm', 'id');
    }
    public function lophocphans()
    {
        return $this->hasMany('App\LopHocPhan', 'magv', 'id');
    }
}
