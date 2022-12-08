<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'brand' => 'required|string',
            'model' => 'required|string',
            'colour' => 'required|string',
            'state_number' => "required|unique:cars,state_number",
            'on_parking' => 'boolean',
        ]);

        Car::createCar($request);

        return redirect()->route('clients.show', $request->client_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'colour' => 'required|string|max:20',
            'state_number' => "required|unique:cars,state_number,$id|max:20",
            'on_parking' => 'boolean',
        ]);

        Car::updateCar($request, $id);

        $client_id = Car::getClientIdOfCar($id);

        return redirect()->route('clients.show', $client_id->client_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function delete($id)
    {
        $client_id = Car::getClientIdOfCar($id);

        $count = Car::countOfClientCars($client_id);

        if ($count > 1) // If client has two cars at least
        {
            Car::deleteCar($id);
            return back()->withInput();
        }
        else {
            return back()->withErrors("Can't delete this car. Client must have at least a one car");
        }
    }
}
