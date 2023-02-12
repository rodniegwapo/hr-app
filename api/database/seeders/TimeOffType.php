<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeOffType extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('types')->insert([
            'name' => 'sick leave',
        ]);
        DB::table('types')->insert([
            'name' => 'vacation',
        ]);
        DB::table('types')->insert([
            'name' => 'personal day',
        ]);
    }
}
