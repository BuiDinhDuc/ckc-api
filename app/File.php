<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = ['tenfile', 'ngaytao', 'duoifile', 'dungluong', 'trangthai', 'path', 'matk', 'file_name'];

    public function filebaiviets()
    {
        return $this->hasMany('App\FileBaiViet', 'mafile', 'id');
    }
    public function taikhoan()
    {
        return $this->belongsTo('App\User', 'matk', 'matk');
    }
}
