<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Auth\User as Authenticatable;


class User extends Authenticatable
{
    protected $connection = 'mongodb';
    protected $collection = 'users';
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password','fullname','avatar','about_me','admin','provider','provider_id','token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions() {
        return $this->hasMany('App\Question','user_id','_id');
    }

    public function answers() {
        return $this->hasMany('App\Answer','user_id','_id');
    }

    public function notifications() {
        return $this->hasMany('App\Notification','user_id','_id');
    }


    public function likeDislike()
    {
        return $this->hasMany('App\LikeDislike','user_id','_id');
    }

    public function do_notifications() {
        return $this->hasMany('App\Notification','actor_id','_id');

    }

    public function messages() {
        return $this->hasMany('App\Message','from_user','_id');
    }
}
