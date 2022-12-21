<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    static public function getMainInfo()
    {
        return DB::table('clients')
            ->select([
                'clients.id',
                'clients.full_name',
                'cars.brand',
                'cars.model',
                'cars.id as cars_id',
                'cars.state_number',
            ])
            ->join('cars', 'clients.id', '=', 'cars.client_id')
            ->paginate(7);
    }

    /**
     * @param Request $request
     * @return id of new created client
     */
    static public function createClient(Request $request)
    {
        DB::table('clients')
            ->insert([
                'full_name' => $request->full_name,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ]);
         return DB::table('clients')
            ->select('id')
            ->where('phone_number', '=', $request->phone_number)
            ->get()[0]->id;
    }

    static public function getClient($id)
    {
        return DB::table('clients')
            ->select([
                'clients.id',
                'clients.full_name',
                'clients.gender',
                'clients.phone_number',
                'clients.address',
            ])
            ->where('id', '=', $id)
            ->first();
    }

    static public function updateClient(Request $request, $id)
    {
        DB::table('clients')
        ->where('id', '=', $id)
        ->update(
            [
                'full_name' => $request->full_name,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ]
        );
    }
    static public function deleteClient($id)
    {
        DB::table('clients')
            ->where('id', '=', $id)
            ->delete();
    }
    use HasFactory;
}
