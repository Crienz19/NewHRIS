<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->float('VL');
            $table->float('SL');
            $table->float('OT');
            $table->float('OB');
            $table->float('PTO');
            $table->float('unused_VL');
            $table->float('unused_SL');
            $table->integer('total_PTO');
            $table->integer('total_VL');
            $table->integer('total_SL');
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
        Schema::dropIfExists('credits');
    }
}
