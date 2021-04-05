<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoMon extends Model
{
    public function khoa(){
        return $this->belongsTo('App\Khoa','makhoa','makhoa');
    }
}
