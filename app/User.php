<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $primaryKey = 'matk';
    use Notifiable;
    protected $fillable = ['email', 'password',];
    protected $hidden = ['password', 'remember_token',];
    protected $casts = ['email_verified_at' => 'datetime',];

    public function sinhvien()
    {
        return $this->hasOne('App\SinhVien', 'matk', 'matk');
    }
    public function giangvien()
    {
        return $this->hasOne('App\GiangVien', 'matk', 'matk');
    }
    public function baiviets()
    {
        return $this->hasMany('App\BaiViet', 'matk', 'matk');
    }
    public function binhluans()
    {
        return $this->hasMany('App\BinhLuan', 'matk', 'matk');
    }
    public function files()
    {
        return $this->hasMany('App\File', 'matk', 'matk');
    }
}
