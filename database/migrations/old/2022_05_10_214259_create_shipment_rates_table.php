<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_from');
            $table->unsignedBigInteger('city_to');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->double('rate');
            $table->timestamps();

            $table->foreign('city_from')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('city_to')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipment_rates');
    }
};
