<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
class Notification extends Eloquent
{
    /**
     * Array contain actions below:
     * answer like dislike vote
     */
    static public $action = array('answer'=>'answer','like'=>'like','dislike'=>'dislike','accept'=>'accept','deleted'=>'deleted');

    /**
     * Array of targets:
     * question answer
     */
    static public $target = array('question'=>'question','answer'=>'answer');

    protected $connection = 'mongodb';
    protected $collection = 'notifications';
    public function user() {
    	return $this->belongsTo('App\User', 'user_id', '_id');
    }
    public function actor() {
    	return $this->belongsTo('App\User', 'actor_id', '_id');
    }
}



