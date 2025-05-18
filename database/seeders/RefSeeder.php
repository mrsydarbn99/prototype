<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefSeeder extends Seeder
{
    public function run()
    {
        DB::table('ref_locations')->insert([
            ['name' => 'FAB 1'],
            ['name' => 'FAB 2'],
        ]);

        DB::table('ref_cabinets')->insert([
            ['code' => 'FLA'],
            ['code' => 'FLB'],
            ['code' => 'EMA'],
            ['code' => 'EMB'],
            ['code' => 'MDB'],
            ['code' => 'MTA'],
            ['code' => 'MTB'],
            ['code' => 'IRB'],
        ]);

        DB::table('ref_types')->insert([
            ['name' => 'Flex/A565'],
            ['name' => 'Eagle/MMCI'],
            ['name' => 'MMAD'],
            ['name' => 'MMST'],
            ['name' => 'IR'],
        ]);
    }
}
