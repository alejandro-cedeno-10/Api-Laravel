<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->foreignId('id_factura');
            $table->foreign('id_factura')->references('id')->on('facturas')->onDelete('cascade')->onUpdate('cascade');
          
            $table->foreignId('id_producto');
            $table->foreign('id_producto')->references('id')->on('productos')->onDelete('cascade')->onUpdate('cascade');
          
            $table->integer('cantidad');
            $table->float('precio',4, 2);
            $table->timestamps();

            $table->primary(['id_factura','id_producto']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles');
    }
}
