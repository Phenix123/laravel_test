<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $clients = DB::table('clients')
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
        #$clients=Client::first();
        #return $clients->toArray();
        return view('index', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('create_client');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|min:3',
            'gender' => 'boolean',
            'phone_number' => "required|unique:clients,phone_number",
            'address' => 'nullable|string',
            'model' => 'required|string',
            'brand' => 'required|string',
            'colour' => 'required|string',
            'state_number'=> 'required|unique:cars,state_number',
            'on_parking'=> 'boolean'
        ]);

        ##dd($request);
        $full_name = $request->input('full_name');
        $gender = $request->input('gender');
        $phone_num = $request->input('phone_number');
        $address = $request->input('address');


        DB::table('clients')
            ->insert([
                'full_name' => $full_name,
                'gender' => $gender,
                'phone_number' => $phone_num,
                'address' => $address,
            ]);

        $client_id = DB::table('clients')
            ->select('id')
            ->where('phone_number', '=', $phone_num)
            ->get()[0]->id;

        $brand = $request->input('brand');
        $model = $request->input('model');
        $colour = $request->input('colour');
        $state_number = $request->input('state_number');
        $on_parking = $request->input('on_parking');
        //dd($brand, $model, $colour, $state_number, $on_parking);
        DB::table('cars')
            ->insert([
                'brand' => $brand,
                'model' => $model,
                'colour' => $colour,
                'state_number' => $state_number,
                'on_parking' => $on_parking,
                'client_id' => $client_id
            ]);

        return redirect()->route('clients.show', str($client_id));
    }

    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {
        //dd($client);

        $cur_client = DB::table('clients')
            ->select([
                'clients.id',
                'clients.full_name',
                'clients.gender',
                'clients.phone_number',
                'clients.address',
            ])
            ->where('id', '=', $id)
            ->first();

        $cur_client_cars = DB::table('cars')
            ->select([
                'cars.id',
                'cars.brand',
                'cars.model',
                'cars.colour',
                'cars.state_number',
                'cars.on_parking',
            ])
            ->where('client_id', '=', $id)
            ->get();

        return view('edit_client', [
            'cur_client' => $cur_client,
            'cars' => $cur_client_cars
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        //dd($request);
        $request->validate([
            'full_name' => 'required|min:3',
            'gender' => 'boolean',
            'phone_number' => "required|unique:clients,phone_number,$id",
            'address' => 'nullable|string',
        ]);

        $cur_client = DB::table('clients')
            ->where('id', '=', $id)
            ->update(
                [
                'full_name' => $request->full_name,
                'gender' => $request->gender,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                ]
    );
        return redirect()->route('clients.show', str($id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        //
        DB::table('clients')
            ->where('id', '=', $id)
            ->delete();

        return redirect()->route('clients.index');
    }
}
