<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class LikeDislike extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'like_dislike';
    public function user() {
    	return $this->belongsTo('App\User', 'user_id', '_id');
    }
    public function question() {
    	return $this->belongsTo('App\Question', 'post_id', '_id');
    }
    public function answer() {
    	return $this->belongsTo('App\Answer', 'post_id', '_id');
    }

}
