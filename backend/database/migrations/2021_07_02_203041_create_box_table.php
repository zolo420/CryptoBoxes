<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('box', function (Blueprint $table) {
            $table->id();
            $table->json('seed');
            $table->integer('price');
            $table->decimal('starting_bank', 8, 8);
            $table->string('address');
            $table->string('cryptocurrency', 10);
            $table->tinyInteger('box_type');
            $table->boolean('is_archive')->default(0);
            $table->boolean('is_open')->default(0);
            $table->foreignId('winner')->nullable()->references('id')->on('users');
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
        Schema::dropIfExists('box');
    }
}
