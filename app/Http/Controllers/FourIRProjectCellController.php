<?php

namespace App\Http\Controllers;

use App\Models\FourIRProjectCell;
use App\Services\FourIRServices\FourIRProjectCellService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class FourIRProjectCellController extends Controller
{
    public FourIRProjectCellService $fourIRProjectCellService;
    private Carbon $startTime;

    /**
     * FourIRProjectCellController constructor.
     *
     * @param FourIRProjectCellService $fourIRProjectCellService
     */
    public function __construct(FourIRProjectCellService $fourIRProjectCellService)
    {
        $this->startTime = Carbon::now();
        $this->fourIRProjectCellService = $fourIRProjectCellService;
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
//        $this->authorize('viewAny', FourIRProjectCell::class);

        $filter = $this->fourIRProjectCellService->filterValidator($request)->validate();
        $response = $this->fourIRProjectCellService->getFourIRProjectCellList($filter, $this->startTime);
        return Response::json($response,ResponseAlias::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function read(int $id): JsonResponse
    {
        $fourIrProjectCell = $this->fourIRProjectCellService->getOneFourIRProjectCell($id);
//        $this->authorize('view', $fourIrProject);
        $response = [
            "data" => $fourIrProjectCell,
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
//        $this->authorize('create', FourIRProjectCell::class);

        $validated = $this->fourIRProjectCellService->validator($request)->validate();
        $data = $this->fourIRProjectCellService->store($validated);

        $response = [
            'data' => $data,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => "Four Ir Project added successfully",
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
        $fourIrProjectCell = FourIRProjectCell::findOrFail($id);
//        $this->authorize('update', $fourIrProject);

        $validated = $this->fourIRProjectCellService->validator($request, $id)->validate();
        $data = $this->fourIRProjectCellService->update($fourIrProjectCell, $validated);

        $response = [
            'data' => $data,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Four Ir Project updated successfully",
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
        $fourIrProjectCell = FourIRProjectCell::findOrFail($id);
//        $this->authorize('delete', $fourIrProject);
        $this->fourIRProjectCellService->destroy($fourIrProjectCell);
        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Four Ir Project deleted successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}