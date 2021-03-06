<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\JobManagement;
use App\Services\JobManagementServices\JobContactInformationService;
use App\Services\JobManagementServices\JobManagementService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class JobContactInformationController extends Controller
{

    public JobContactInformationService $jobContactInformationService;
    public JobManagementService $jobManagementService;
    public Carbon $startTime;

    /**
     * @param JobContactInformationService $jobContactInformationService
     * @param JobManagementService $jobManagementService
     */
    public function __construct(JobContactInformationService $jobContactInformationService, JobManagementService $jobManagementService)
    {
        $this->jobContactInformationService = $jobContactInformationService;
        $this->jobManagementService = $jobManagementService;
        $this->startTime = Carbon::now();
    }


    /**
     * @param string $jobId
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function getContactInformation(string $jobId): JsonResponse
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
        if ($step >= BaseModel::FORM_STEPS['JobContactInformation']) {
            $jobInformation = $this->jobContactInformationService->getContactInformation($jobId);
            $jobInformation["latest_step"] = $step;
            $response["data"] = $jobInformation;
            $response['_response_status']["query_time"] = $this->startTime->diffInSeconds(Carbon::now());
        }
        return Response::json($response, ResponseAlias::HTTP_OK);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function storeContactInformation(Request $request): JsonResponse
    {
        $this->authorize('create', JobManagement::class);
        $validatedData = $this->jobContactInformationService->validate($request)->validate();
        $jobInformation = $this->jobContactInformationService->store($validatedData);
        $response = [
            "data" => $jobInformation,
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}
