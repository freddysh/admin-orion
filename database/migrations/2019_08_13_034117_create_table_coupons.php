<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCoupons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',50)->unique()->comment('codigo del cupon');
            $table->string('short_title',200)->comment('titulo corto del cupon');
            $table->string('title',200)->comment('titulo del cupon');
            $table->longText('detail')->comment('detalle del cupon');
            $table->integer('discount')->default('1')->comment('descuento en %');
            $table->integer('state')->default('1')->comment('estado del cupon 0:oculto,1:mostrar');
            $table->timestamps();
            // $table->primary('id')->comment('asignamos atributo de calve primaria al producto');
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
        Schema::dropIfExists('coupons');
    }
}
