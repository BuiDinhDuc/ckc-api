<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonHoc extends Model
{
    protected $fillable = ['tenmh', 'tinchi', 'trangthai'];
    public function lophocphans()
    {
        return $this->hasMany('App\LopHocPhan', 'mamh', 'id');
    }
}
