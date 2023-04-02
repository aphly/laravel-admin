<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_manager', function (Blueprint $table) {
            $table->unsignedBigInteger('uuid')->primary();
            $table->unsignedBigInteger('level_id')->index();
            $table->string('username',32)->unique();
            $table->string('nickname',32)->nullable();
            $table->string('email',128)->nullable();
            $table->string('phone',16)->nullable();
            $table->string('password');
            $table->string('token')->unique();
            $table->integer('token_expire')->unsigned();
            $table->string('avatar',255)->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:正常;2:冻结;3:待审核;')->index();
            $table->tinyInteger('gender')->default(1);
            $table->string('last_ip',64)->nullable();
            $table->unsignedBigInteger('last_time')->nullable();
            $table->string('note',255)->nullable();
            $table->string('user_agent',255)->nullable();
            $table->string('accept_language',255)->nullable();
            $table->unsignedBigInteger('created_at');
            $table->unsignedBigInteger('updated_at');
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_manager');
    }
};
