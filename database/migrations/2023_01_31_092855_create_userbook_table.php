<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserbookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userbook', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bookId');
            $table->unsignedBigInteger('userId');
            $table->foreign('bookId')->references('id')->on('books');
            $table->foreign('userId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userbook');
    }
}