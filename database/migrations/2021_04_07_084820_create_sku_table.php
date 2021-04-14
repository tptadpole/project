<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sku', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('users_id');
            $table->integer('spu_id');
            $table->string('name');
            $table->integer('price');
            $table->string('specification');
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
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
        Schema::dropIfExists('sku');
    }
}
