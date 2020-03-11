<?php

namespace App\Observers;

use App\Answer;
use Illuminate\Support\Facades\Storage;

class AnswerObserver
{
    /**
     * Handle the answer "created" event.
     *
     * @param  \App\Answer  $answer
     * @return void
     */
    public function created(Answer $answer)
    {
        //
    }

    /**
     * Handle the answer "updated" event.
     *
     * @param  \App\Answer  $answer
     * @return void
     */
    public function updated(Answer $answer)
    {
        //
    }

    /**
     * Handle the answer "deleted" event.
     *
     * @param  \App\Answer  $answer
     * @return void
     */
    public function deleted(Answer $answer)
    {
        if(!empty($answer->attachment_path)) Storage::delete('public/files/'.$answer->attachment_path);;
    }

    /**
     * Handle the answer "restored" event.
     *
     * @param  \App\Answer  $answer
     * @return void
     */
    public function restored(Answer $answer)
    {
        //
    }

    /**
     * Handle the answer "force deleted" event.
     *
     * @param  \App\Answer  $answer
     * @return void
     */
    public function forceDeleted(Answer $answer)
    {
        //foreach($answer->get() as $single_answer){
        //    if(!empty($single_answer->attachment_path)) File::delete('files\\'.$single_answer->attachment_path);
        //}
    }
}
