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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
            $table->integer('game_id');
            $table->integer('field11')->default(0);
            $table->integer('field12')->default(0);
            $table->integer('field13')->default(0);
            $table->integer('field21')->default(0);
            $table->integer('field22')->default(0);
            $table->integer('field23')->default(0);
            $table->integer('field31')->default(0);
            $table->integer('field32')->default(0);
            $table->integer('field33')->default(0);
            $table->timestamps();

            $table->unique('game_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fields');
    }
};
