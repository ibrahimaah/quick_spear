<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Setting::create([
            'website_name' => 'none',
            'website_logo' => 'none',
            'website_email' => 'none',
            'first_char_account_number' => 'none',
        ]);
    }
}
