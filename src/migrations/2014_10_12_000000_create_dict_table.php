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
        Schema::create('admin_dict', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uuid')->default(0)->index();
            $table->string('name',64);
            $table->string('key',64)->index();
            $table->integer('sort')->nullable();
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
        Schema::dropIfExists('admin_dict');
    }
};
