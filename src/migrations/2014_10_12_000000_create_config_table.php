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
        Schema::create('admin_config', function (Blueprint $table) {
            $table->id();
            $table->string('name',64);
            $table->string('type',64);
            $table->string('key',64);
            $table->text('value');
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
        Schema::dropIfExists('admin_config');
    }
};
