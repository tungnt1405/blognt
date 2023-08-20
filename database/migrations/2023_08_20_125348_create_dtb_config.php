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
        Schema::create('dtb_config', function (Blueprint $table) {
            $table->uuid()->primary()->unique()->index(); //id
            $table->string('website_name', 255)->nullable(); // tên trang web
            $table->string('email_admin', 255)->nullable();
            $table->tinyInteger('maintain')->default(false); // maintain: 0: false, 1: true ==> type: tinyint
            // 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dtb_config');
    }
};
