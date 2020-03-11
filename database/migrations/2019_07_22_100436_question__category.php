<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuestionCategory extends Migration
{
 public function up()
 {
    Schema::create('question_category', function (Blueprint $table) {

        $table->integer('category_id')->unsigned()->index();
        $table->foreign('category_id')->references('_id')->on('categories');
        $table->integer('question_id')->unsigned()->index();
        $table->foreign('question_id')->references('_id')->on('questions');
    });
}

/**
 * Reverse the migrations.
 *
 * @return void
 */
public function down()
{
    Schema::dropIfExists('question_category');
}
}
