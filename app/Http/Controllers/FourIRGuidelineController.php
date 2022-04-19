<?php

namespace App\Http\Controllers;

use App\Services\FourIRServices\FourIRGuidelineService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class FourIRGuidelineController extends Controller
{
    public FourIRGuidelineService $fourIRGuidelineService;
    private Carbon $startTime;

    /**
     * FourIRGuidelineController constructor.
     *
     * @param FourIRGuidelineService $fourIRGuidelineService
     */
    public function __construct(FourIRGuidelineService $fourIRGuidelineService)
    {
        $this->startTime = Carbon::now();
        $this->fourIRGuidelineService = $fourIRGuidelineService;
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function read(int $id): JsonResponse
    {
        $guideline = $this->fourIRGuidelineService->getOneGuideline($id);
        // $this->authorize('view', $rank);
        $response = [
            "data" => $guideline,
            "_response_status" => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    function store(Request $request): JsonResponse
    {
        //$this->authorize('create', FourIRGuideline::class);

        $validated = $this->fourIRGuidelineService->validator($request)->validate();
        $data = $this->fourIRGuidelineService->store($validated);

        $response = [
            'data' => $data,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_CREATED,
                "message" => "Four Ir Guideline added successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];

        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }
}