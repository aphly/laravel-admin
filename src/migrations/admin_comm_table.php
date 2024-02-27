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
        Schema::create('admin_comm', function (Blueprint $table) {
            $table->id();
            $table->string('name',64);
            $table->string('host',128);
            $table->string('auth_key',128);
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
        Schema::dropIfExists('admin_comm');
    }
};
