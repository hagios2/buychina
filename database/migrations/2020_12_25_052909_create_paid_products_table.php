<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaidProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paid_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('product_id')->unsigned();
            $table->string('status')->default('pending');
            $table->integer('product_payment_id')->unsigned()->nullable();
            $table->decimal('amount', 10, 2);
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
        Schema::dropIfExists('paid_products');
    }
}
