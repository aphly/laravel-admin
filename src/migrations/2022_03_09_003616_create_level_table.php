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
        Schema::create('admin_level', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uuid')->default(0)->index();
            $table->string('name',64);
            $table->unsignedBigInteger('pid');
            $table->unsignedInteger('sort')->index()->default(1);
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('status');
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
        Schema::dropIfExists('admin_level');
    }
};
