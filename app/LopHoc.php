<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LopHoc extends Model
{
    protected $primaryKey = 'malh';


    public function lophoc()
    {
        return $this->belongsTo('App\Khoa', 'mabm', 'mabm');
    }
}
