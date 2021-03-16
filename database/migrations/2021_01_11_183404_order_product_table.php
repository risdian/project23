<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->decimal('price', 20, 2)->nullable();
            $table->decimal('quantity', 20, 2)->nullable();
            $table->string('shipping')->nullable();
            $table->decimal('shipping_price', 20, 2)->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('tracking_status')->nullable();
            $table->dateTime('tracking_datetime')->nullable();
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
        Schema::dropIfExists('order_product');
    }
}
