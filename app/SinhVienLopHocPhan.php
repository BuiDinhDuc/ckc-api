<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SinhVienLopHocPhan extends Model
{
    protected $fillable = ['masv_lhp', 'masv', 'malhp', 'trangthai'];
    protected $primaryKey = 'masv_lhp';
}
