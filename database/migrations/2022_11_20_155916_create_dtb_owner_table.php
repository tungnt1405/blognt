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
        Schema::create('dtb_owner', function (Blueprint $table) {
            $table->id();
            $table->longText('avatar')->nullable();
            $table->string('name', 100);
            $table->text('introduce')->nullable();
            $table->string('gmail_url', 1000)->nullable();
            $table->string('fb_url', 1000)->nullable();
            $table->string('twitter_url', 1000)->nullable();
            $table->string('linkin_url', 1000)->nullable();
            $table->string('zalo_url', 1000)->nullable();
            $table->string('github_url', 1000)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dtb_owner');
    }
};
