<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOrdersProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quality')->default('0')->comment('cantidad escojida');
            $table->integer('product_id')->unsigned()->comment('producto escojido');
            $table->decimal('pu', 8, 2)->comment('precio unitario del producto');
            $table->integer('order_id')->unsigned()->comment('orden al que pertenece');
            $table->timestamps();
            // $table->primary('id')->comment('asignamos atributo de clave primaria');
            // $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('cascade');
            // $table->charset = 'utf8';
            // $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_products');
    }
}
