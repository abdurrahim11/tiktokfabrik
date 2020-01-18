<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrontUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('front_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp_no')->nullable();
            $table->string('address')->nullable();
            $table->string('password')->nullable();
            $table->string('tiktok_username')->nullable();
            $table->string('tiktok_password')->nullable();
            $table->string('tiktok_county')->nullable();
            $table->string('tiktok_target_interest')->nullable();
            $table->string('tiktok_follower_no')->nullable();
            $table->string('subscription_status')->nullable();
            $table->string('agreement_id')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('pay_vai')->nullable();
            $table->string('pay_time')->nullable();
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
        Schema::dropIfExists('front_users');
    }
}
