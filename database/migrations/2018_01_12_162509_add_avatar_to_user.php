<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvatarToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->default("")->comment('头像');
            $table->tinyInteger('gender')->default(0)->comment('性别');
            $table->string('autograph')->nullable()->comment('签名');
            $table->integer('score')->default(0)->comment('积分');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('avatar');
            $table->dropColumn('gender');
            $table->dropColumn('autograph');
            $table->dropColumn('score');
        });
    }
}
