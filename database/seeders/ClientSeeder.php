<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i = 0; $i < 10; $i++){
            DB::table('clients')->insert([
                'full_name'=>Str::random(10)." ".Str::random(10)." ".Str::random(10),
                'gender'=>rand(0,1),
                'phone_number'=>'8('.rand(100,999).')'.rand(100, 999).'-'.rand(10,99).'-'.rand(10, 99),
                'address'=>Str::random(25),
            ]);
        }
    }
}
