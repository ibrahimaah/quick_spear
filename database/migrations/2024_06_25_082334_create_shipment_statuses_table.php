<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('shipment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); 
        });

        DB::table('shipment_statuses')->insert(
            [
                ['id' => 1, 'name' => 'Under Review'],
                ['id' => 2, 'name' => 'Under Delivery'],
                ['id' => 3, 'name' => 'Delivered'],
                ['id' => 4, 'name' => 'Rejected Without Pay'],
                ['id' => 5, 'name' => 'Rejected With Pay'], 
                ['id' => 6, 'name' => 'Postponed'],
                ['id' => 7, 'name' => 'No Response'], 
                ['id' => 8, 'name' => 'Canceled'] 
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipment_statuses');
    }
};
