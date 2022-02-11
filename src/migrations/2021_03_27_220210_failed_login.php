<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Failedlogin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('failed_login', function (Blueprint $table) {
            $table->string('ip',64)->primary();
            $table->string('username',32)->index()->nullable();
            $table->integer('user_id')->index()->nullable();
            $table->integer('count')->unsigned();
            $table->integer('lastupdate')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('failed_login');
    }
}
