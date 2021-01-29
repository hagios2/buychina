<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchandisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchandisers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->text('company_description');
            $table->integer('campus_id')->unsigned();
            $table->integer('shop_type_id')->unsigned();
            $table->string('avatar')->nullable();
            $table->string('cover_photo')->nullable();
            $table->string('password');
            $table->boolean('isActive')->default(true);
            $table->string('payment_status')->default('payment required');
            $table->timestamp('qualified_for_free_trial')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
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
        Schema::dropIfExists('merchandisers');
    }
}
