<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('seller_id')->unsigned()->default(0);
            $table->string('name');
            $table->integer('amount')->unsigned()->default(0);
            $table->integer('vote')->default(0);
            $table->string('comment');
            $table->integer('stock')->unsigned()->default(0);
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
        Schema::dropIfExists('spu');
    }
}
