<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Car extends Model
{
    /**
     * @return Collection
     */
    static public function getAll()
    {
        return DB::table('cars')
            ->select([
                'id',
                'model',
                'brand',
                'colour',
                'state_number'
            ])->get();
    }

    /**
     * @param $id
     * @return Collection
     */
    public static function getCarById($id)
    {
        return DB::table('cars')
            ->select([
                'id',
                'model',
                'brand',
                'colour',
                'state_number'
            ])
            ->where('id', $id)
            ->get();
    }

    static public function createCar(Request $request)
    {
        DB::table('cars')
            ->insert([
                'brand' => $request->brand,
                'model' => $request->model,
                'colour' => $request->colour,
                'state_number' => $request->state_number,
                'on_parking' => $request->on_parking,
                'client_id'=> $request->client_id,
            ]);
        return DB::table('cars')
            ->select('id')
            ->where('state_number', '=', $request->state_number)
            ->get()[0]->id;
    }

    static public function updateCar(Request $request, $id)
    {
        DB::table('cars')
            ->where('id', '=', $id)
            ->update(
                [
                    'brand' => $request->brand,
                    'model' => $request->model,
                    'colour' => $request->colour,
                    'state_number' => $request->state_number,
                    'on_parking' => $request->on_parking,
                ]
            );
    }

    static public function getClientCars($client_id)
    {
        return DB::table('cars')
            ->select([
                'cars.id',
                'cars.brand',
                'cars.model',
                'cars.colour',
                'cars.state_number',
                'cars.on_parking',
            ])
            ->where('client_id', '=', $client_id)
            ->get();
    }
    static public function getClientIdOfCar($id)
    {
        return DB::table('cars')
            ->select('client_id')
            ->where('id', '=', $id)
            ->first();
    }

    static public function deleteCar($id)
    {
        DB::table('cars')
            ->where('id', '=', $id)
            ->delete();
    }

    public static function countOfClientCars($client_id)
    {
        return DB::table('cars')
            ->where('client_id', '=', str($client_id->client_id))
            ->count('client_id');
    }
    use HasFactory;
}
