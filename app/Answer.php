<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Answer extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'answers';
    
    protected $fillable = [
        'content','user_id','question_id',
    ];

    public function user() {
    	return $this->belongsTo('App\User', 'user_id', '_id');
    }
    
    public function question() {
    	
    	return $this->belongsTo('App\Question', 'question_id', '_id');
    }

    public function likeDislike() {

    	return $this->hasMany('App\LikeDislike', 'post_id', '_id');
    }

}