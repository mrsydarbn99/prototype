<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RefType;
use App\Models\RefLocation;
use App\Models\RefCabinet;
use App\Models\Cabinet;

class CabinetSeeder extends Seeder
{
    public function run()
    {
        $types = RefType::pluck('id', 'name');
        $locations = RefLocation::pluck('id', 'name');
        $cabinets = RefCabinet::pluck('id', 'code');

        $data = [
            // Flex/A565
            ['type' => 'Flex/A565', 'prefix' => 'FLA', 'location' => 'FAB 1', 'range' => 500],
            ['type' => 'Flex/A565', 'prefix' => 'FLB', 'location' => 'FAB 2', 'range' => 500],

            // Eagle/MMCI
            ['type' => 'Eagle/MMCI', 'prefix' => 'EMA', 'location' => 'FAB 1', 'range' => 1000],
            ['type' => 'Eagle/MMCI', 'prefix' => 'EMB', 'location' => 'FAB 2', 'range' => 1000],

            // MMAD
            ['type' => 'MMAD', 'prefix' => 'MDB', 'location' => 'FAB 2', 'range' => 300],

            // MMST
            ['type' => 'MMST', 'prefix' => 'MTA', 'location' => 'FAB 1', 'range' => 100],
            ['type' => 'MMST', 'prefix' => 'MTB', 'location' => 'FAB 2', 'range' => 100],

            // IR
            ['type' => 'IR', 'prefix' => 'IRB', 'location' => 'FAB 2', 'range' => 1000],
        ];

        foreach ($data as $item) {
            for ($i = 1; $i <= $item['range']; $i++) {
                Cabinet::create([
                    'ref_type_id' => $types[$item['type']],
                    'ref_location_id' => $locations[$item['location']],
                    'ref_cabinet_id' => $cabinets[$item['prefix']],
                    'cabinet_no' => $item['prefix'] . str_pad($i, 4, '0', STR_PAD_LEFT),
                ]);
            }
        }
    }
}
