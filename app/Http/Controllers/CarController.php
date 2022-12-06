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
        //
        DB::table('cars')
            ->insert([
                'brand' => $request->brand,
                'model' => $request->model,
                'colour' => $request->colour,
                'state_number' => $request->state_number,
                'on_parking' => $request->on_parking,
                'client_id'=> $request->client_id,
            ]);

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
            'brand' => 'required|string',
            'model' => 'required|string',
            'colour' => 'required|string',
            'state_number' => "required|unique:cars,state_number,$id",
            'on_parking' => 'boolean',
        ]);
        //sdd($request);
        $cur_car = DB::table('cars')
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
        $client_id = DB::table('cars')
            ->select('client_id')
            ->where('id', '=', $id)->first();
        //dd($client_id->client_id);
        return redirect()->route('clients.show', $client_id->client_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function delete($id)
    {
        $client_id = DB::table('cars')
            ->select('client_id')
            ->where('id', '=' , $id)
            ->first();
        $count = DB::table('cars')
            ->where('client_id', '=', str($client_id->client_id))
            ->count('client_id');

        if ($count > 1) // If client has two cars at least
        {
            DB::table('cars')
                ->where('id', '=', $id)
                ->delete();

            return back()->withInput();
        }
        else {
            return back()->withErrors("Can't delete this car. Client must have at least a one car");
        }
    }
}
