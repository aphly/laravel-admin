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
        Schema::create('admin_module', function (Blueprint $table) {
            $table->id();
            $table->string('name',64);
            $table->string('key',64)->index();
            $table->string('classname',255);
            $table->tinyInteger('status')->nullable()->default(1);
            $table->integer('sort')->nullable()->default(0);
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
        Schema::dropIfExists('admin_module');
    }
};
