<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTamanoProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tamano_productos', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->foreignId('id_tamano');
            $table->foreign('id_tamano')->references('id')->on('tamanos')->onDelete('cascade')->onUpdate('cascade');
          
            $table->foreignId('id_producto');
            $table->foreign('id_producto')->references('id')->on('productos')->onDelete('cascade')->onUpdate('cascade');
          
            $table->float('precio',4, 2);
            $table->integer('stock')->nullable();
            $table->timestamps();

            $table->primary(['id_tamano','id_producto']);
      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tamano_productos');
    }
}
