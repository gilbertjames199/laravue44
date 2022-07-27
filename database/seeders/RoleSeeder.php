<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now();
        $dateTime = $date->format('Y-m-d');
        DB::table('roles')->insert([
            'name' => 'admin',
            'desc' => 'admin description',
            'created_at' => $dateTime,
            'updated_at' => $dateTime,
        ]);
        DB::table('roles')->insert([
            'name' => 'user',
            'desc' => 'user description',
            'created_at' => $dateTime,
            'updated_at' => $dateTime,
        ]);
    }
}
