<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FirstUserSeeder extends Seeder
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
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'email_verified_at' =>$dateTime,
            'password' => Hash::make('12345678'),
            'pass_con' => Hash::make('12345678'),
            'role_id'=>'1',
            'created_at' => $dateTime,
            'updated_at' => $dateTime,
        ]);
    }
}
