<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileBaiViet extends Model
{
    protected $fillable = ['mafile', 'mabv', 'trangthai'];

    public function file()
    {
        $this->belongsTo('App\File', 'mafile', 'mafile');
    }
    public function baiviet()
    {
        $this->belongsTo('App\BaiViet', 'mabv', 'mabv');
    }
}
