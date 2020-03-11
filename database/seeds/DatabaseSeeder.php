<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Question;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->email = 'admin@mail.com';
        $user->password = bcrypt(123456);
        $user->fullname = 'Antman';
        $user->avatar = 'antman_avatar.png';
        $user->about_me = 'We are antman team!';
        $user->admin = 1;
      
        $user->save();

        $category_name = array('C++/C#', 'Database', 'Java', 'Javascript', 'Mobile', 'Python', 'Ruby', 'Software', 'Website', 'Other');
        $cat = null;
        foreach($category_name as $name){
            $category = new Category();
            $category->name = $name;
            $category->save();
            $cat = $category;
        }

        $question = new Question();
        $question->title='If you had one day left to live, what would you do?';
        $question->content='# The world is going to die!
![](https://cdn.inquisitr.com/wp-content/uploads/2017/09/september-doomsday-endoftheworld.jpg)
### Imagine in the beautiful day, there are some news that the globle is too old so it is going to die tommorrow.
# What you will do?
### Tell me your crazy idea :D.';
        $question->attachment_path=null;
        $question->user()->associate($user);
        $question->category()->associate($cat);
        $question->total_like=0;
        $question->total_dislike=0;
        $question->total_answer=0;
        $question->save();

        // create index for full text search
        Schema::connection('mongodb')->table('questions', function (Blueprint $collection) {
            $collection->index([ "title" => "text","content" => "text" ]);
        });
    }
}
