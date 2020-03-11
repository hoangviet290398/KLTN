<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Category extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'categories';
    protected $fillable = [
        'name'
    ];
    public function questions()
    {
        return $this->hasMany('App\Question','category_id','_id');
    }

    static public function getStringId(){
        $categories = Category::get(['_id']);

        $string = "";
        foreach($categories as $category){
            $string = $string."$category->_id,";
        }
        return $string;
    }
}


