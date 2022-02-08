<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Manager extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manager', function (Blueprint $table) {
            $table->id();
            $table->char('guid',32)->unique();
            $table->string('username',32)->unique();
            $table->string('nickname',32);
            $table->string('email',128);
            $table->string('phone',16);
            $table->string('password');
            $table->string('token')->unique();
            $table->integer('token_expire')->unsigned();
            $table->string('avatar',255);
            $table->tinyInteger('status');
            $table->integer('last_login')->unsigned();
            $table->string('last_ip',64);
            $table->rememberToken();
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
        Schema::dropIfExists('manager');
    }
}
