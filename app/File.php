<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['mafile', 'tenfile', 'ngaytao', 'duoifile', 'dungluong', 'trangthai'];
    protected $primaryKey = 'mafile';
    public function filebaiviets()
    {
        return $this->hasMany('App\FileBaiViet', 'mafile', 'mafile');
    }
    public function taikhoan()
    {
        return $this->belongsTo('App\User', 'matk', 'matk');
    }
}
