.<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostState extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('posts_state', function (Blueprint $table) {
//            $table->increments('id');
//            $table->integer('post_id');
//            $table->tinyInteger('top')->default(0)->comment('置顶帖');
//            $table->tinyInteger('rsuv')->default(0)->comment('精华帖');
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('posts_state');
    }
}
