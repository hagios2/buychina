<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('merchandiser_id')->unsigned()->nullable();
            $table->string('cardno');
            $table->string('expirymonth');
            $table->string('expiryyear');
            $table->string('country')->default('GH');
            $table->string('currency')->default('GHS');
            $table->string('cvv');
            $table->string('billingzip')->nullable();
            $table->string('billingcity')->nullable();
            $table->string('billingaddress')->nullable();
            $table->string('billingstate')->nullable();
            $table->string('billingcountry')->default('GH');
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
        Schema::dropIfExists('billing_details');
    }
}
