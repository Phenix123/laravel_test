<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\Request;

class CarApiController extends Controller
{
    //
    public function index()
    {
        $cars = Car::getAll();
        return CarResource::collection($cars);
    }

    public function show($id)
    {
        $car = Car::getCarById($id);
        return CarResource::collection($car);
    }

}
