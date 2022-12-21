<?php

namespace App\Http\Controllers;

use App\Models\Car;
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
        $clients = Client::getMainInfo();

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
            'full_name' => 'required|min:3|max:100',
            'gender' => 'boolean',
            'phone_number' => "required|unique:clients,phone_number|max:15",
            'address' => 'nullable|string|max:100',
            'model' => 'required|string|max:100',
            'brand' => 'required|string|max:100',
            'colour' => 'required|string|max:20',
            'state_number'=> 'required|unique:cars,state_number|max:20',
            'on_parking'=> 'boolean'
        ]);


        $client_id =  Client::createClient($request);

        $request->merge(['client_id' => $client_id]);

        Car::createCar($request);

        return redirect()->route('clients.show', str($client_id));
    }

    /**
     * Display the specified resource.
     *
     */
    public function show($id)
    {
        //dd($client);

        $cur_client = Client::getClient($id);

        $cur_client_cars = Car::getClientCars($id);

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
            'full_name' => 'required|min:3|max:100',
            'gender' => 'boolean',
            'phone_number' => "required|unique:clients,phone_number,$id|max:15",
            'address' => 'nullable|string|max:100',
        ]);

        Client::updateClient($request, $id);

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
        Client::deleteClient($id);

        return redirect()->route('clients.index');
    }
}
