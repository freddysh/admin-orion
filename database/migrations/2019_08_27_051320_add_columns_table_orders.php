<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->dateTime('pending_date')->nullable()->comment('fecha que se hizo el pedido');
            $table->dateTime('dispatched_date')->nullable()->comment('fecha que se hizo el despacho');
            $table->integer('dispatched_user')->default(0)->comment('usuario del sistema que despacho el despacho');
            $table->integer('dispatched_driver')->default(0)->comment('driver que llevo el pedido');
            $table->dateTime('processed_date')->nullable()->comment('fecha que se hizo proceso el pedido');
            $table->integer('processed_user')->default(0)->comment('usuario del sistema que proceso el pedido');
            $table->dateTime('canceled_date')->nullable()->comment('fecha que se cancelo el pedido');
            $table->integer('canceled_user')->default(0)->comment('usuario del sistema que cancelo el pedido');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
