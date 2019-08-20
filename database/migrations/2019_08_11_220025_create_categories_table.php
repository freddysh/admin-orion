<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',100)->comment('nombre de la categoria');
            $table->string('photo',200)->nullable()->comment('foto de la categoria');
            $table->integer('father_id')->default('0')->comment('padre al que pertenece');
            $table->integer('state')->default('1')->comment('estado de la categoria 0:oculto,1:mostrar');
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
        Schema::dropIfExists('categories');
    }
}
