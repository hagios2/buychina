<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellersPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->integer('billing_detail_id')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('phonenumber');
            $table->integer('product_id')->unsigned();
            $table->string('vendor')->nullable();
            $table->string('momo_payment')->default(false);
            $table->string('txRef')->unique();
            $table->string('device_ip');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('sellers_payments');
    }
}
