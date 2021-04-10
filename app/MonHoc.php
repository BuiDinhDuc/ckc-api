<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonHoc extends Model
{
    protected $fillable = ['mamh', 'tenmh', 'tinchi', 'trangthai'];
    protected $primaryKey = 'mamh';
    public function lophocphans()
    {
        return $this->hasMany('App\LopHocPhan', 'mamh', 'mamh');
    }
}
