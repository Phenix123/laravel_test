<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $clients = DB::table('clients')->select('id')->get();
        foreach($clients as $client)
        {
            $cars = rand(1,4);
            for( $i = 0; $i < $cars; $i++)
            {
                DB::table('cars')->insert([
                    'brand'=>Str::random(7),
                    'model'=>Str::random(7),
                    'colour'=>Str::random(7),
                    'state_number'=>Str::random(2).rand(100,999).Str::random(1).rand(10,999),
                    'on_parking'=>rand(0,1),
                    'client_id'=>$client->id,
                ]);
            }
        }
    }
}
