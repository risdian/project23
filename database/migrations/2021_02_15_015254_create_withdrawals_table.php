<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('request_amount', 8, 2);
            $table->dateTime('request_date');
            $table->string('account_name');
            $table->string('account_number');
            $table->string('bank_name');

            $table->enum('status', ['pending', 'processing', 'completed', 'decline'])->default('pending');

            $table->unsignedBigInteger('pic_id')->nullable();
            $table->dateTime('approval_date')->nullable();
            $table->decimal('approval_amount', 8, 2)->nullable();
            $table->string('Transaction_id')->nullable();
            $table->dateTime('Transaction_date')->nullable();

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
        Schema::dropIfExists('withdrawals');
    }
}
