<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsersAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_address', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name',200)->comment('nombre del cliente');
            $table->string('email',200)->unique()->comment('email del cliente');
            $table->string('phone',20)->comment('nro del telefono o celular del cliente');
            $table->string('departament',40)->comment('departamento del cliente');
            $table->string('province',40)->comment('provincia cliente');
            $table->string('distrite',40)->comment('distrito del cliente');
            $table->integer('user_id')->unsigned()->comment('cliente que utilizo');
            $table->timestamps();
            // $table->primary('id')->comment('asignamos atributo de clave primaria');
            // $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('users_address');
    }
}
