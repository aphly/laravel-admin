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
        Schema::create('admin_statistics', function (Blueprint $table) {
            $table->id();
            $table->char('ipv4',15)->index();
            $table->char('ipv6',39)->nullable();
            $table->string('url',255);
            $table->string('referrer',255)->nullable();
            $table->string('keyword',64)->nullable();
            $table->string('language',64)->nullable();
            $table->string('platform',32)->nullable();
            $table->string('userAgent',255)->nullable();
            $table->unsignedInteger('view')->nullable()->default(1);
            $table->tinyInteger('webdriver')->default(0)->nullable();
            $table->unsignedBigInteger('created_at');
            $table->unsignedBigInteger('updated_at');
            //$table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_statistics');
    }
};
