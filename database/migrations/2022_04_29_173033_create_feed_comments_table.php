<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_comments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('feed_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('feed_id')->references('id')->on('feed');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('comment', 1000);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_comments');
    }
}
