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
        Schema::create('territories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });

        DB::table('territories')->insert([
            ['id' => 1, 'name' => 'إقليم الشمال'],
            ['id' => 2, 'name' => 'إقليم الوسط'],
            ['id' => 3, 'name' => 'إقليم الجنوب'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('territories');
    }
};
