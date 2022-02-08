<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RbacUserRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rbac_user_role', function (Blueprint $table) {
            $table->id();
            $table->char('guid',32);
            $table->bigInteger('role_id')->unsigned();
            $table->index('guid');
            $table->index('role_id');
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
        Schema::dropIfExists('rbac_user_role');
    }
}
