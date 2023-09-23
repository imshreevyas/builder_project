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
        Schema::create('user_properties', function (Blueprint $table) {
            $table->id();
            $table->string('map_id');
            $table->integer('user_id');
            $table->integer('property_id');
            $table->integer('total_amount')->default(0);
            $table->integer('total_amount_paid')->default(0);
            $table->integer('flat_no')->default(0);
            $table->integer('status')->default(1)->comment('1:ongoing,0:closed');
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
        Schema::dropIfExists('user_properties');
    }
};