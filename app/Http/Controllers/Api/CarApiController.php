<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\JsonResponse as JsonResponseAlias;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CarApiController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $cars = Car::getAll();
        return CarResource::collection($cars);
    }

    /**
     * @param $id
     * @return AnonymousResourceCollection
     */
    public function show($id)
    {
        $car = Car::getCarById($id);
        return CarResource::collection($car);
    }

    /**
     * @param Request $request
     * @return JsonResponseAlias
     */
    public function store(Request $request)
    {
        $validator = $this->validateRequest($request);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }


        $carId = Car::createCar($request);
        $car = Car::getCarById($carId);

        return CarResource::collection($car)
            ->additional(['message' => trans('notifications.create.success')])
            ->response()
            ->setStatusCode(ResponseAlias::HTTP_ACCEPTED);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponseAlias
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validateRequestWithoutClientId($request, $id);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()], 422);
        }

        Car::updateCar($request, $id);
        $car = Car::getCarById($id);

        return CarResource::collection($car)
            ->additional(['message' => trans('notifications.update.success')])
            ->response()
            ->setStatusCode(ResponseAlias::HTTP_ACCEPTED);
    }

    /**
     * @param $id
     * @return JsonResponseAlias
     */
    public function delete(Request $request, $id)
    {
        $car = Car::getCarById($id);
        if ($car->isEmpty())
            return response()->json(['errors' => "car with current id doesn't exist"], 422);
        else {
            Car::deleteCar($id);
            return response()
                ->json(['message' => trans('notifications.delete.success'),])
                ->setStatusCode(ResponseAlias::HTTP_OK);
        }
    }

    /**
     * @param Request $request
     * @return void
     */
    private function validateRequest(Request $request)
    {
        return $validator = Validator::make($request->all(), [
            'brand' => 'required|string',
            'model' => 'required|string',
            'colour' => 'required|string',
            'state_number' => "required|unique:cars,state_number",
            'on_parking' => 'boolean',
            'client_id' => 'required'
        ]);
    }

    private function validateRequestWithoutClientId(Request $request, $id)
    {
        return $validator = Validator::make($request->all(), [
            'brand' => 'required|string',
            'model' => 'required|string',
            'colour' => 'required|string',
            'state_number' => "required|unique:cars,state_number,$id|max:20",
            'on_parking' => 'boolean',
        ]);
    }
}
