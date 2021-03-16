<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJNTsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('j_n_ts', function (Blueprint $table) {
            $table->id();
            $table->string('shipping_type');
            $table->string('country');
            $table->string('region');
            $table->string('zip_from');
            $table->string('zip_to');
            $table->decimal('price', 20, 2)->nullable();
            $table->decimal('weight_from', 20, 2)->nullable();
            $table->decimal('weight_to', 20, 2)->nullable();
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
        Schema::dropIfExists('j_n_ts');
    }
}
