<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('avatar');
            $table->integer('city');
            $table->integer('language');
            $table->integer('province');
            $table->integer('position');
            $table->string('post_code');
            $table->string('phone_number');
            $table->string('business_phone');
            $table->string('account_type');
            $table->string('company_name');
            $table->string('company_website');
            $table->string('tax_number');
            $table->string('company_email_address');
            $table->string('email')->unique();
            $table->string('country')->nullable(true);
            $table->string('password');
            $table->boolean('is_valid')->default(false);
            $table->string('token')->nullable();
            $table->string('activate_status')->default(true);
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('users');
    }
}
