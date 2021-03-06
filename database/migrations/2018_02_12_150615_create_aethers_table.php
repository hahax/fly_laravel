<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAethersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aethers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('文件名');
            $table->string('path')->nullable()->comment('地址');
            $table->string('ip')->comment('上传人ip');
            $table->string('user_id')->comment('上传人id');
            $table->string('size')->comment('文件大小');
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
        Schema::dropIfExists('aethers');
    }
}
