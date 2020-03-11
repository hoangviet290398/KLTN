<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Elasticquent\ElasticquentTrait;

class Question extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'questions';
    protected $fillable = [
        'title','content','user_id','best_answer','category_id','total_like','total_dislike','total_answer'
    ];

    public function category()
    {
    	return $this->belongsTo('App\Category','category_id','_id');
    }

    public function user() {
    	return $this->belongsTo('App\User', 'user_id', '_id');
    }

    public function answers() {

    	return $this->hasMany('App\Answer', 'question_id', '_id');
    }

    public function likeDislike() {

    	return $this->hasMany('App\LikeDislike', 'post_id', '_id');
    }

    public function bestAnswer() {

        return $this->hasOne('App\Answer', '_id', 'best_answer_id');
    }
}

