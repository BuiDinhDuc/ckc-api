<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Khoa extends Model
{
    protected $fillable = ['tenkhoa', 'ngaylap', 'trangthai'];

    public function bomons()
    {
        return $this->hasMany('App\BoMon', 'makhoa', 'id');
    }
}
