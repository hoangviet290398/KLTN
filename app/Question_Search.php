<?php

namespace App;

use Illuminate\Database\Eloquent\Model as Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Elasticquent\ElasticquentTrait;

class Question_Search extends Model
{
    use ElasticquentTrait;
    protected $connection = 'elastic';
    protected $collection = 'q&asystem.questions';
    public $fillable = [
        'title','content','user_id','best_answer','category_id','total_like','total_dislike','total_answer'
    ];


    


}

