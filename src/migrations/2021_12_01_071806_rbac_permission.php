<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RbacPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rbac_permission', function (Blueprint $table) {
            $table->id();
            $table->string('name', 32)->nullable();
            $table->string('route', 255);
            $table->string('controller', 255);
            $table->bigInteger('parent_id', 0)->unsigned();
            $table->tinyInteger('nav_type', 0)->unsigned();
            $table->integer('nav_sort', 0)->unsigned();
            $table->bigInteger('manager_id')->unsigned();
            $table->bigInteger('module_id')->unsigned();
            $table->timestamps();
            $table->index('parent_id');
            $table->index(['nav_type']);
            $table->index('manager_id');
            $table->index('module_id');
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
        Schema::dropIfExists('rbac_permission');
    }
}
