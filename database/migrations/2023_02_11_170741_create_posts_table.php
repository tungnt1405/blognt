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
        Schema::create('dtb_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
            $table->foreignId('category_id')
                ->references('id')
                ->on('mtb_categories')
                ->cascadeOnDelete();
            $table->string('title', 255);
            $table->string('slug', 1000);
            $table->text('description');
            $table->longText('content');
            $table->integer('parent_id')->nullable();
            $table->tinyInteger('series')->default(0);
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
        Schema::dropIfExists('dtb_posts');
    }
};
