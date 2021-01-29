<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('merchandiser_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->text('report');
            $table->text('reply')->nullable();
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
        Schema::dropIfExists('shop_reports');
    }
}
