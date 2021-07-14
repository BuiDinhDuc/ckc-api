<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileBaiViet extends Model
{
    protected $fillable = ['mafile', 'mabv', 'trangthai'];

    public function file()
    {
        return  $this->hasOne('App\File', 'id', 'mafile');
    }
    public function baiviet()
    {
        return  $this->belongsTo('App\BaiViet', 'mabv', 'id');
    }
}
