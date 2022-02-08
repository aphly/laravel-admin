<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RbacRolePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rbac_role_permission', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('role_id')->unsigned();
            $table->bigInteger('permission_id')->unsigned();
            $table->bigInteger('parent_role_id')->unsigned();
            $table->index('role_id');
            $table->index('permission_id');
            $table->index('parent_role_id');
            $table->timestamps();
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
        Schema::dropIfExists('rbac_role_permission');
    }
}
