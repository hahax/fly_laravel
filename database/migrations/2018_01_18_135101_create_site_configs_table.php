<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiteConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_configs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site_name')->comment('网站标题')->nullable();
            $table->string('seo')->comment('SEO标题')->nullable();
            $table->string('seo_key')->comment('SEO关键字')->nullable();
            $table->tinyInteger('user_reg')->comment('会员注册')->nullable();
            $table->tinyInteger('forum_sh')->comment('发帖审核')->nullable();
            $table->tinyInteger('email_sh')->comment('邮箱验证')->nullable();
            $table->string('site_copyright')->comment('版权信息')->nullable();
            $table->string('site_icp')->comment('ICP备案号')->nullable();
            $table->text('site_tongji')->comment('统计代码')->nullable();
            $table->string('smtp_host')->comment('SMTP服务器')->nullable();
            $table->string('smtp_port')->comment('SMTP端口号')->nullable();
            $table->string('smtp_name')->comment('SMTP用户名')->nullable();
            $table->string('smtp_password')->comment('SMTP密码')->nullable();
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
        Schema::dropIfExists('site_configs');
    }
}
