<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('post_code');
            $table->string('country');
            $table->string('city');
            $table->string('smtp_username')->nullable();
            $table->string('smtp_host')->nullable();
            $table->string('smtp_port')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('paypal_email')->nullable();
            $table->string('paypal_currency')->nullable();
            $table->string('stripe_publish_key')->nullable();
            $table->string('stripe_email')->nullable();
            $table->string('stripe_secret_key')->nullable();
            $table->string('stripe_country')->nullable();
            $table->string('stripe_currency')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('insta_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('google_link')->nullable();
            $table->boolean('status');
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
        Schema::dropIfExists('companies');
    }
}
