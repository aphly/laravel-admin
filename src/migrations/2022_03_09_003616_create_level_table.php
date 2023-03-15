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
            $table->string('name',64);
            $table->unsignedBigInteger('pid')->index();
            $table->integer('sort')->unsigned()->index()->nullable();
            $table->tinyInteger('is_leaf')->default(1)->index();
            $table->tinyInteger('status')->index();
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
