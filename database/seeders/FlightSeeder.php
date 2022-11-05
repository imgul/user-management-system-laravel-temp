<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('flights')->insert([
            'cust_name' => Str::random(10),
            'cust_email' => Str::random(10).'@gmail.com',
            'cust_phone' => Str::random(10),
            'cust_address' => Str::random(10),
            'cust_country' => Str::random(10),
        ]);
    }
}
