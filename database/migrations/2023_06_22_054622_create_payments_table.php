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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->integer('property_id');
            $table->integer('emi_count')->comment('emi number,e.g 2, 3rd emi');
            $table->integer('emi_amount');
            $table->integer('due_date');
            $table->string('transaction_id')->nullable();
            $table->string('remark')->nullable();
            $table->integer('status')->default(0)->comment('0:pending,1:paid');
            $table->integer('updated_by');
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
        Schema::dropIfExists('payments');
    }
};