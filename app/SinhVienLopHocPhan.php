<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SinhVienLopHocPhan extends Model
{
    protected $fillable = ['masv', 'malhp', 'trangthai'];

    public function sinhviens(){
        return $this->hasMany('App\SinhVien', 'id', 'masv')->with('lophoc');
    }
}
