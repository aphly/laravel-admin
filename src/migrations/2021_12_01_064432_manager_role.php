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
        Schema::create('admin_manager_role', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uuid');
            $table->unsignedBigInteger('role_id');
            $table->index('uuid');
            $table->index('role_id');
            //$table->timestamps();
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
        Schema::dropIfExists('admin_manager_role');
    }
};
