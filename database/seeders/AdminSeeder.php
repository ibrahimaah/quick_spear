<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name'      => 'مشرف',
            'email'     => 'admin@admin.com',
            'phone'     => '01022844240',
            'password'  => bcrypt('123456789')
        ]);
    }
}
