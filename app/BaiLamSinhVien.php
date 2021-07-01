<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaiLamSinhVien extends Model
{
    protected $fillable = ['link', 'mafile', 'mabv', 'mssv', 'trangthai'];

    public function file()
    {
        return $this->hasOne('App\File', 'id', 'mafile');
    }
}
