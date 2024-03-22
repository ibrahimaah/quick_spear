<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // shipper data
            $table->unsignedBigInteger('address_id'); // shipper data

            // consignee data
            $table->string('consignee_name');
            $table->string('consignee_email');
            $table->string('consignee_phone');
            $table->string('consignee_cell_phone');
            $table->string('consignee_country_code');
            $table->unsignedBigInteger('consignee_city');
            $table->string('consignee_zip_code');
            $table->string('consignee_line1');
            $table->string('consignee_line2');
            $table->string('consignee_line3');
            // Shipment Data
            $table->timestamp('shipping_date_time');
            $table->date('due_date');
            $table->string('comments')->nullable();
            $table->string('pickup_location');
            $table->string('pickup_guid')->nullable();
            $table->double('weight');
            $table->string('goods_country')->nullable(); // optional
            $table->integer('number_of_pieces'); // number of items
            $table->string('description'); // description
            $table->string('shipmentID'); // description
            $table->text('shipmentLabelURL'); // description
            $table->text('shipmentAttachments'); // description
            $table->string('reference')->default(); // reference to print on shipment report (policy)
            $table->string('shipper_reference')->nullable(); // optional
            $table->string('consignee_reference')->nullable(); // optional
            $table->string('services')->default('CODS');
            $table->string('cash_on_delivery_amount')->nullable(); // in case of CODS (in USD only "as they want")
            $table->string('insurance_amount')->nullable(); // optional
            $table->string('collect_amount')->nullable(); // optional
            $table->string('customs_value_amount')->nullable(); //optional (required for express shipping)
            $table->string('cash_additional_amount')->nullable(); // optional
            $table->string('cash_additional_amount_description')->nullable();
            $table->string('product_group')->default('DOM'); // or EXP (defined in config file, if you dont pass it will take the config value)
            $table->string('product_type')->default('PPX'); // or EXP (defined in config file, if you dont pass it will take the config value)
            $table->string('payment_type')->default('P'); // or EXP (defined in config file, if you dont pass it will take the config value)
            $table->string('payment_option')->nullable(); // refer to the official documentation
            $table->timestamps();

            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
            // $table->foreign('consignee_city')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipments');
    }
};
