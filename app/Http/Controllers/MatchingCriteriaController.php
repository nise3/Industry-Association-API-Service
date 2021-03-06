<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\JobManagement;
use App\Services\JobManagementServices\JobManagementService;
use App\Services\JobManagementServices\MatchingCriteriaService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class MatchingCriteriaController extends Controller
{
    public MatchingCriteriaService $matchingCriteriaService;
    public JobManagementService $jobManagementService;
    public Carbon $startTime;

    /**
     * @param MatchingCriteriaService $matchingCriteriaService
     * @param JobManagementService $jobManagementService
     */
    public function __construct(MatchingCriteriaService $matchingCriteriaService, JobManagementService $jobManagementService)
    {
        $this->matchingCriteriaService = $matchingCriteriaService;
        $this->jobManagementService = $jobManagementService;
        $this->startTime = Carbon::now();

    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException|Throwable
     */
    public function storeMatchingCriteria(Request $request): JsonResponse
    {
        $this->authorize('create', JobManagement::class);
        $validatedData = $this->matchingCriteriaService->validator($request)->validate();
        DB::beginTransaction();
        try {
            $matchingCriteria = $this->matchingCriteriaService->store($validatedData);
            $response = [
                "data" => $matchingCriteria,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "PrimaryJobInformation successfully submitted",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now())
                ]
            ];
            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param string $jobId
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getMatchingCriteria(string $jobId): JsonResponse
    {
        $this->authorize('view', JobManagement::class);

        $step = $this->jobManagementService->lastAvailableStep($jobId);
        $response = [
            "data" => [
                "latest_step" => $step
            ],
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        if ($step >= BaseModel::FORM_STEPS['MatchingCriteria']) {
            $matchingCriteria = $this->matchingCriteriaService->getMatchingCriteria($jobId);
            if (empty($matchingCriteria))
                $matchingCriteria = $this->matchingCriteriaService->getMatchingCriteriaRelatedInfo($jobId);

            $matchingCriteria["latest_step"] = $step;
            $response["data"] = $matchingCriteria;
            $response['_response_status']["query_time"] = $this->startTime->diffInSeconds(Carbon::now());
        }
        return Response::json($response, ResponseAlias::HTTP_OK);

    }
}
