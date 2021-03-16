<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourierRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courier_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('courier_id');
            $table->string('country');
            $table->string('region');
            $table->string('zip_from');
            $table->string('zip_to');
            $table->decimal('price', 20, 2)->nullable();
            $table->decimal('weight_from', 20, 2)->nullable();
            $table->decimal('weight_to', 20, 2)->nullable();
            $table->foreign('courier_id')->references('id')->on('couriers')->onDelete('cascade');
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
        Schema::dropIfExists('courier_rates');
    }
}
