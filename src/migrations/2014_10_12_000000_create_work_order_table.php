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
        Schema::create('admin_work_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('msg_detail_id')->default(0)->index();
            $table->unsignedInteger('viewed')->nullable()->default(1);
            $table->tinyInteger('status')->nullable()->default(1);
            $table->unsignedBigInteger('uuid')->default(0)->index();
            $table->unsignedBigInteger('to_uuid')->default(0)->index();
            $table->unsignedBigInteger('created_at');
            $table->unsignedBigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_work_order');
    }
};
