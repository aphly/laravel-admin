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
        Schema::create('admin_role', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32)->nullable();
            $table->tinyInteger('status')->unsigned()->default(1)->comment('1:开启; 0:关闭')->index();
            $table->unsignedInteger('sort', 0)->default(0)->nullable()->index();
            $table->unsignedBigInteger('level_id')->index();
            $table->unsignedTinyInteger('add')->default(1)->comment('1:开启; 2:关闭');
            $table->unsignedTinyInteger('del')->default(1)->comment('1:开启; 2:关闭');
            $table->unsignedTinyInteger('show')->default(1)->comment('1:开启; 2:关闭');
            $table->unsignedTinyInteger('edit')->default(1)->comment('1:开启; 2:关闭');
            $table->unsignedTinyInteger('data')->default(1)->comment('1:自己; 2:本级以下')->index();
            $table->unsignedBigInteger('module_id')->index();
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
        Schema::dropIfExists('admin_role');
    }
};
