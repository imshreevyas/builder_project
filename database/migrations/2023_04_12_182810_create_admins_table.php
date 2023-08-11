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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('email',100)->unique();
            $table->string('mobile',12)->unique();
            $table->string('username');
            $table->string('password');
            $table->string('address',100)->nullable();
            $table->string('last_login_ip');
            $table->string('logo')->nullable();
            $table->datetime('last_login_time');
            $table->integer('created_by');
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
        Schema::dropIfExists('admins');
    }
};