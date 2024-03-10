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
        Schema::create('admin_links', function (Blueprint $table) {
            $table->id();
            $table->string('name',64);
            $table->string('icon',255)->nullable();
            $table->string('url',255)->nullable();
            $table->integer('pid')->unsigned();
            $table->integer('sort')->unsigned()->nullable()->default(0);
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_links');
    }
};
