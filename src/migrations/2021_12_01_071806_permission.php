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
        Schema::create('permission', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32);
            $table->string('controller', 255)->nullable();
            $table->bigInteger('pid', 0)->unsigned()->default(0);
            $table->integer('sort', 0)->unsigned()->default(0);
            $table->tinyInteger('status')->unsigned()->default(1)->comment('1:开启; 0:关闭');
            $table->index('pid');
            $table->index('sort');
            $table->index('status');
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
        Schema::dropIfExists('permission');
    }
};
