<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Throwable;
use App\Services\ServiceService;
use Illuminate\Http\Request;

/**
 * Class ServiceController
 * @package App\Http\Controllers
 */
class ServiceController extends Controller
{
    /**
     * @var ServiceService
     */
    public ServiceService $serviceService;
    private Carbon $startTime;

    /**
     * ServiceController constructor.
     * @param ServiceService $serviceService
     */
    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
        $this->startTime = Carbon::now();
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Exception|JsonResponse|Throwable
     */
    public function getList(Request $request):JsonResponse
    {
        try {
            $response = $this->serviceService->getServiceList($request, $this->startTime);
        } catch (Throwable $e) {
            return $e;
        }
        return Response::json($response);
    }

    /**
     * Display the specified resource
     * @param int $id
     * @return Exception|JsonResponse|Throwable
     */
    public function read(int $id):JsonResponse
    {
        try {
            $response = $this->serviceService->getOneService($id, $this->startTime);
        } catch (Throwable $e) {
            return $e;
        }
        return Response::json($response);

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    function store(Request $request):JsonResponse
    {
        $validatedData = $this->serviceService->validator($request)->validate();
        try {
            $data = $this->serviceService->store($validatedData);

            $response = [
                'data' => $data ?: null,
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_CREATED,
                    "message" => "Service added successfully",
                    "started" => $this->startTime->format('H i s'),
                    "finished" => Carbon::now()->format('H i s'),
                ]
            ];
        } catch (Throwable $e) {
            return $e;
        }

        return Response::json($response, JsonResponse::HTTP_CREATED);
    }

    /**
     * update the specified resource in storage
     * @param Request $request
     * @param int $id
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException
     */
    public function update(Request $request, int $id)
    {

        $service = Service::findOrFail($id);

        $validated = $this->serviceService->validator($request,$id)->validate();

        try {
            $data = $this->serviceService->update($service, $validated);

            $response = [
                'data' => $data ? $data : null,
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_OK,
                    "message" => "Service updated successfully",
                    "started" => $this->startTime->format('H i s'),
                    "finished" => Carbon::now()->format('H i s'),
                ]
            ];

        } catch (Throwable $e) {
            return $e;
        }

        return Response::json($response, JsonResponse::HTTP_CREATED);

    }

    /**
     *  remove the specified resource from storage
     * @param int $id
     * @return Exception|JsonResponse|Throwable
     */
    public function destroy(int $id):JsonResponse
    {
        $service = Service::findOrFail($id);

        try {
            $this->serviceService->destroy($service);
            $response = [
                '_response_status' => [
                    "success" => true,
                    "code" => JsonResponse::HTTP_OK,
                    "message" => "Service deleted successfully",
                    "started" => $this->startTime->format('H i s'),
                    "finished" => Carbon::now()->format('H i s'),
                ]
            ];
        } catch (Throwable $e) {
            return $e;
        }
        return Response::json($response, JsonResponse::HTTP_OK);
    }
}
