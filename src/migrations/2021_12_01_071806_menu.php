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
        Schema::create('admin_menu', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32)->nullable();
            $table->string('url', 255)->nullable();
            $table->bigInteger('pid', 0)->unsigned()->default(0)->index();
            $table->tinyInteger('status')->unsigned()->default(1)->comment('1:开启; 0:关闭')->index();
            $table->unsignedInteger('sort', 0)->default(0)->nullable()->index();
            $table->string('icon', 32)->nullable();
            $table->tinyInteger('is_leaf')->unsigned()->default(1)->index();
            $table->unsignedBigInteger('level_id')->index();
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
        Schema::dropIfExists('admin_menu');
    }
};
