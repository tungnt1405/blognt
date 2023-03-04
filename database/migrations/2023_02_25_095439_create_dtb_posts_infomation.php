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
        Schema::create('dtb_posts_infomation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')
                ->references('id')
                ->on('dtb_posts')
                ->cascadeOnDelete();
            $table->boolean('status')->default(0);
            $table->dateTimeTz('public_date', $precision = 0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dtb_posts_infomation');
    }
};
