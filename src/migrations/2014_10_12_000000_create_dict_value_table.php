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
        Schema::create('admin_dict_value', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('dict_id')->index();
            $table->string('name',64)->nullable();
            $table->string('value',255)->nullable();
            $table->tinyInteger('fixed')->default(0);
            $table->integer('sort')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_dict_value');
    }
};
