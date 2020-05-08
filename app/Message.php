<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Message extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'messages';
    protected $fillable=['from_user','to_user','is_read','message','created_at'];
   

    // public function user() {
    //     return $this->belongsTo('App\User', 'user_id', '_id');
    // }

    
}
