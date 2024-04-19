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
        Schema::create('shipment_imports', function (Blueprint $table) {
            $table->id();
            $table->string('AWB');
            $table->string('CODValue');
            $table->string('ShipperNumber')->nullable();
            $table->string('ShipperReference')->nullable();
            $table->string('ShipperReference2')->nullable();
            $table->string('ShipperName')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('transaction_id')->nullable();
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
        Schema::dropIfExists('shipment_imports');
    }
};
