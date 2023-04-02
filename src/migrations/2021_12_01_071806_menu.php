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
            $table->string('route', 255)->nullable();
            $table->bigInteger('pid', 0)->unsigned()->default(0)->index();
            $table->unsignedTinyInteger('status')->default(1)->comment('1:开启; 0:关闭')->index();
            $table->unsignedInteger('sort', 0)->default(0)->nullable()->index();
            $table->string('icon', 32)->nullable();
            $table->unsignedTinyInteger('type')->default(1)->comment(' 1:目录,2:菜单,3:按钮,4:外链;')->index();
            $table->unsignedBigInteger('module_id')->index();
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
        Schema::dropIfExists('admin_menu');
    }
};
