<?php

namespace Database\Seeders;

use App\Models\BridePackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BridePackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BridePackage::factory(100)->create();
    }
}