<?php

namespace Database\Seeders;

use Throwable;
use ErrorException;
use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubdistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            DB::transaction(function () {
                $province = Province::firstOrCreate([
                    'name' => 'Province Name Seed'
                ]);
        
                $city = $province->cities()->firstOrCreate([
                    'name' => 'City Name Seed',
                    'postal_code' => '1000'
                ]);
        
                $sub = $city->subdistricts()->firstOrCreate([
                    'name' => 'Subdistrict Name Seed'
                ]);
            });
        } catch (Throwable $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    
}
