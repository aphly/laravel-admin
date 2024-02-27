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
        Schema::create('admin_api', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uuid')->default(0)->index();
            $table->string('name', 32)->nullable();
            $table->string('route', 255)->nullable();
            $table->bigInteger('pid', 0)->unsigned()->default(0);
            $table->integer('sort', 0)->unsigned()->default(0)->nullable();
            $table->tinyInteger('status')->unsigned()->default(1)->comment('1:开启; 0:关闭');
            $table->unsignedTinyInteger('type')->default(1)->comment(' 1:目录,2:权限');
            $table->unsignedBigInteger('module_id');
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
        Schema::dropIfExists('admin_api');
    }
};
