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
        Schema::create('news_slave', function (Blueprint $table) {

            $table->id();
            $table->string('news_id');
            $table->string('sub_heading');
            $table->string('paragraph',2000);
            $table->string('img');
            $table->string('is_active')->default('1');
            $table->string('is_deleted')->default('0');
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
        Schema::dropIfExists('news_slave');
    }
};
