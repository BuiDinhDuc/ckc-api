<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileBangTin extends Model
{
    protected $fillable = ['mafile', 'mabangtin', 'trangthai'];

    public function file()
    {
        return  $this->hasOne('App\File', 'id', 'mafile');
    }
}
