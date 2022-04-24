<?php

namespace App\Http\Controllers;

use App\Models\FourIRProjectCs;
use App\Services\FourIRServices\FourIRProjectCsService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class FourIRProjectCsController extends Controller
{
    public FourIRProjectCsService $fourIrProjectCsService;
    private Carbon $startTime;

    /**
     * FourIRProjectCsController constructor.
     *
     * @param FourIRProjectCsService $fourIrProjectCsService
     */
    public function __construct(FourIRProjectCsService $fourIrProjectCsService)
    {
        $this->startTime = Carbon::now();
        $this->fourIrProjectCsService = $fourIrProjectCsService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function getList(Request $request): JsonResponse
    {
//        $this->authorize('viewAny', FourIRProjectCs::class);

        $filter = $this->fourIrProjectCsService->filterValidator($request)->validate();
        $response = $this->fourIrProjectCsService->getFourIRProjectCsList($filter, $this->startTime);
        return Response::json($response,ResponseAlias::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function read(int $id): JsonResponse
    {
        $fourIrProjectCs = $this->fourIrProjectCsService->getOneFourIRProjectCs($id);
//        $this->authorize('view', $fourIrProjectCs);
        $response = [
            "data" => $fourIrProjectCs,
            "_response_status" => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response,ResponseAlias::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    function store(Request $request): JsonResponse
    {
//        $this->authorize('create', FourIRProjectCs::class);

        $validated = $this->fourIrProjectCsService->validator($request)->validate();
        $data = $this->fourIrProjectCsService->store($validated);

        $response = [
            'data' => $data,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => "Four Ir Project cs added successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];

        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $fourIrProjectCs = FourIRProjectCs::findOrFail($id);
//        $this->authorize('update', $fourIrProjectCs);

        $validated = $this->fourIrProjectCsService->validator($request, $id)->validate();
        $data = $this->fourIrProjectCsService->update($fourIrProjectCs, $validated);

        $response = [
            'data' => $data,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Four Ir Project cs updated successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];

        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage
     *
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function destroy(int $id): JsonResponse
    {
        $fourIrProjectCs = FourIRProjectCs::findOrFail($id);
//        $this->authorize('delete', $fourIrProjectCs);
        $this->fourIrProjectCsService->destroy($fourIrProjectCs);
        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Four Ir Project cs deleted successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
