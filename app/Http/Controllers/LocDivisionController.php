<?php

namespace App\Http\Controllers;

use App\Services\LocationManagementServices\LocDivisionService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Throwable;

class LocDivisionController extends Controller
{
    /**
     * @var LocDivisionService
     */
    public LocDivisionService $locDivisionService;
    public Carbon $startTime;

    /**
     * LocDivisionController constructor.
     * @param LocDivisionService $locDivisionService
     * @param Carbon $startTime
     */
    public function __construct(LocDivisionService $locDivisionService, Carbon $startTime)
    {
        $this->locDivisionService = $locDivisionService;
        $this->startTime = $startTime;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Exception|JsonResponse|Throwable
     * @throws ValidationException|Throwable
     */
    public function getList(Request $request): JsonResponse
    {
        $filter = $this->locDivisionService->filterValidator($request)->validate();

        try {
            $response = $this->locDivisionService->getAllDivisions($filter, $this->startTime);
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Exception|JsonResponse|Throwable
     */
    public function read(int $id): JsonResponse
    {
        try {
            $response = $this->locDivisionService->getOneDivision($id, $this->startTime);
        } catch (Throwable $e) {
            throw $e;
        }
        return Response::json($response);
    }

}
