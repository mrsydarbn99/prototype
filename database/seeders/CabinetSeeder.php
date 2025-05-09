<?php

namespace Database\Seeders;

use App\Models\Cabinet;
use Illuminate\Database\Seeder;

class CabinetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 30 cabinets
        for ($i = 1; $i <= 30; $i++) {
            Cabinet::create([
                'cabinet_number' => $i,
                'status' => 'available',
                'description' => 'Cabinet #' . $i
            ]);
        }
    }
}
