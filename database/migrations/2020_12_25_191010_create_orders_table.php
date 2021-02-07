<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->enum('status', ['pending', 'processing', 'completed', 'decline'])->default('pending');

            $table->decimal('grand_total', 8, 2);
            $table->decimal('sub_total', 8, 2);
            $table->decimal('tax', 8, 2);

            $table->unsignedInteger('item_count');

            $table->string('payment_status')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_code')->nullable();
            $table->dateTime('payment_datetime')->nullable();
            $table->string('payment_transaction_id')->nullable();

            $table->string('delivery_method')->nullable();
            $table->string('delivery_price')->nullable();

            $table->string('name');
            $table->string('email');
            $table->text('address');
            $table->string('city');
            $table->String('state');
            $table->string('country');
            $table->string('postcode');
            $table->string('phone_number');
            $table->text('notes')->nullable();

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
        Schema::dropIfExists('orders');
    }
}
