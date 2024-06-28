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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('territory_id');
            $table->foreign('territory_id')->references('id')->on('territories');
        });

        DB::table('cities')->insert([
            ['id' => 1, 'name' => 'عمان','territory_id'=>2],
            ['id' => 2, 'name' => 'الزرقاء','territory_id'=>2],
            ['id' => 3, 'name' => 'الكرك','territory_id'=>3],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
};
