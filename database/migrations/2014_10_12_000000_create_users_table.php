<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name',100);
            $table->string('email',100)->unique();
            $table->string('mobile',12)->unique();
            $table->string('address',100);
            $table->integer('property_id')->default(0);
            $table->integer('emi_amount')->default(0);
            $table->integer('emi_count')->default(0);
            $table->string('dcrypt_password');
            $table->string('password');
            $table->datetime('emi_expiry_date')->nullable();
            $table->string('last_login')->nullable();
            $table->rememberToken();
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
};