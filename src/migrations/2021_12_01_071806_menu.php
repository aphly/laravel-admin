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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32);
            $table->string('url', 255)->nullable();
            $table->bigInteger('pid', 0)->unsigned()->default(0);
            $table->tinyInteger('is_leaf', 0)->unsigned()->default(1);
            $table->integer('sort', 0)->unsigned()->default(0);
            $table->index('pid');
            $table->index(['is_leaf']);
            $table->index('sort');
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
        Schema::dropIfExists('menu');
    }
};
