<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('文件名');
            $table->string('path')->nullable()->comment('视频地址');
            $table->string('ip')->comment('上传人ip');
            $table->string('user_id')->comment('上传人id');
            $table->string('file_type')->comment('文件类型');
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
        Schema::dropIfExists('video_lists');
    }
}
