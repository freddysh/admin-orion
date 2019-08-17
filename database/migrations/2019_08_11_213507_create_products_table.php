<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',20)->unique()->comment('codigo del producto');
            $table->string('name',200)->comment('nombre del producto');
            $table->longText('description')->comment('descripcion del producto');
            $table->longText('detail')->comment('detalle del producto');
            $table->decimal('price', 8, 2)->comment('precio del producto');
            $table->decimal('price_promo', 8, 2)->comment('precio del producto');
            $table->integer('state')->default('1')->comment('estado del producto 0:oculto,1:mostrar');
            $table->integer('unity_id')->unsigned()->comment('unidad del producto');
            $table->integer('category_id')->unsigned()->comment('categoria a la que pertenece el producto');
            $table->timestamps();
            // $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
