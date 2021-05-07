<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $fillable = ['email', 'password',];
    protected $hidden = ['password', 'remember_token',];
    protected $casts = ['email_verified_at' => 'datetime',];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sinhvien()
    {
        return $this->hasOne('App\SinhVien', 'matk', 'id');
    }
    public function giangvien()
    {
        return $this->hasOne('App\GiangVien', 'matk', 'id');
    }
    public function baiviets()
    {
        return $this->hasMany('App\BaiViet', 'matk', 'id');
    }
    public function binhluans()
    {
        return $this->hasMany('App\BinhLuan', 'matk', 'id');
    }
    public function files()
    {
        return $this->hasMany('App\File', 'matk', 'id');
    }
}
