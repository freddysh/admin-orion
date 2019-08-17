<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProductsPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('photo')->comment('photo del producto');
            $table->integer('state')->comment('estado de la unidad, 0:principal,1:galeria');
            $table->integer('product_id')->unsigned()->comment('id del producto al que pertenece');
            $table->timestamps();
            // $table->primary('id')->comment('asignamos atributo de calve primaria al producto');
            // $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('products_photos');
    }
}
