<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('branch_id')->index();
            $table->unsignedBigInteger('brand_id')->index();
            $table->unsignedBigInteger('categories')->index();
            $table->string('sku');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('quantity');
            $table->decimal('price', 20, 2);
            $table->decimal('sale_price', 20, 2)->nullable();

            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();

            $table->boolean('status')->default(1);
            $table->boolean('featured')->default(0);

            $table->unsignedBigInteger('counter')->default(0);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('categories')->references('id')->on('categories')->onDelete('cascade');

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
        Schema::dropIfExists('products');
    }
}
