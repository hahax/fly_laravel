<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePicListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pic_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('disk')->comment('存储地址:local/qiniu');
            $table->string('path')->nullable()->comment('local地址');
            $table->string('url')->nullable()->comment('qiniu link');
            $table->string('use')->nullable()->comment('使用：logo/二维码');
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
        Schema::dropIfExists('pic_lists');
    }
}
