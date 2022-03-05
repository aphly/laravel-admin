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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32);
            $table->string('url', 255)->nullable();
            $table->bigInteger('pid', 0)->unsigned()->default(0)->index();
            $table->tinyInteger('status')->unsigned()->default(1)->comment('1:开启; 0:关闭')->index();
            $table->integer('sort', 0)->unsigned()->default(0)->index();
            $table->string('icon', 32)->nullable();
            $table->tinyInteger('is_leaf')->unsigned()->default(1)->index();
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
        Schema::dropIfExists('menu');
    }
};
