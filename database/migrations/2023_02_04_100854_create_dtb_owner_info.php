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
        Schema::create('dtb_owner_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')
                ->references('id')
                ->on('dtb_owner')
                ->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->longText('make_project')->nullable();
            $table->longText('experience')->nullable();
            $table->string('career_goals', 1000)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dtb_owner_info');
    }
};
