<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commission_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commission_id');
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('range_start', 8, 2)->nullable();
            $table->decimal('range_end', 8, 2)->nullable();
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
        Schema::dropIfExists('commission_attributes');
    }
}
