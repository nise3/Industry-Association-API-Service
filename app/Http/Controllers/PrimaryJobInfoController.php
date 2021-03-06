<?php

namespace App\Http\Controllers;

use App\Models\BaseModel;
use App\Models\JobManagement;
use App\Models\PrimaryJobInformation;
use App\Services\JobManagementServices\JobManagementService;
use App\Services\JobManagementServices\PrimaryJobInformationService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class PrimaryJobInfoController extends Controller
{
    public PrimaryJobInformationService $primaryJobInformationService;
    public JobManagementService $jobManagementService;
    public Carbon $startTime;

    /**
     * @param PrimaryJobInformationService $primaryJobInformationService
     * @param JobManagementService $jobManagementService
     */
    public function __construct(PrimaryJobInformationService $primaryJobInformationService, JobManagementService $jobManagementService)
    {
        $this->primaryJobInformationService = $primaryJobInformationService;
        $this->jobManagementService = $jobManagementService;
        $this->startTime = Carbon::now();

    }

    public function getJobId(): JsonResponse
    {
        $response = [
            "data" => PrimaryJobInformation::jobId(),
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException|Throwable
     */
    public function storePrimaryJobInformation(Request $request): JsonResponse
    {
        $this->authorize('create', JobManagement::class);
        $validatedData = $this->primaryJobInformationService->validator($request)->validate();
        $employmentTypes = $validatedData['employment_types'];
        DB::beginTransaction();
        try {
            $primaryJobInformation = $this->primaryJobInformationService->store($validatedData);
            $this->primaryJobInformationService->syncWithEmploymentStatus($primaryJobInformation, $employmentTypes);
            $response = [
                "data" => $primaryJobInformation,
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
    public function getPrimaryJobInformation(string $jobId): JsonResponse
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
        if ($step >= BaseModel::FORM_STEPS['PrimaryJobInformation']) {
            $primaryJobInformation = $this->primaryJobInformationService->getPrimaryJobInformationDetails($jobId);

            $primaryJobInformation["latest_step"] = $step;
            $response["data"] = $primaryJobInformation;
            $response['_response_status']["query_time"] = $this->startTime->diffInSeconds(Carbon::now());
        }
        return Response::json($response, ResponseAlias::HTTP_OK);

    }

    /**
     * @param Request $request
     * @param string $jobId
     * @return JsonResponse
     * @throws Throwable
     * @throws ValidationException
     */
    public function jobStatusChange(Request $request, string $jobId): JsonResponse
    {
        $this->authorize('update', JobManagement::class);

        $response = [];
        $statusCode = ResponseAlias::HTTP_UNPROCESSABLE_ENTITY;

        if ($this->primaryJobInformationService->isJobPublishOrArchiveApplicable($jobId)) {
            $primaryJobInformation = PrimaryJobInformation::where('job_id', $jobId)->firstOrFail();
            $validatedData = $this->primaryJobInformationService->publishOrArchiveValidator($request,$primaryJobInformation)->validate();
            $primaryJobInformationModificationFlag = $this->primaryJobInformationService->publishOrArchiveOrDraftJob($validatedData, $primaryJobInformation);
            $message = "";
            if ($request->input('status') == PrimaryJobInformation::STATUS_PUBLISH) {
                $message = $primaryJobInformationModificationFlag ? "Job published successfully done" : "Job published is not done";
            }
            if ($request->input('status') == PrimaryJobInformation::STATUS_ARCHIVE) {
                $message = $primaryJobInformationModificationFlag ? "Job archived successfully done" : "Job archived is not done";
            }
            if ($request->input('status') == PrimaryJobInformation::STATUS_DRAFT) {
                $message = $primaryJobInformationModificationFlag ? "The draft of Jop posting is successfully done" : "The draft of Jop posting is not done";
            }

            $statusCode = $primaryJobInformationModificationFlag ? ResponseAlias::HTTP_OK : ResponseAlias::HTTP_UNPROCESSABLE_ENTITY;
            $response = [
                '_response_status' => [
                    "success" => $primaryJobInformationModificationFlag,
                    "code" => $statusCode,
                    'message' => $message,
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now())
                ]
            ];
        } else {
            $statusCode = ResponseAlias::HTTP_BAD_REQUEST;
            $response = [
                '_response_status' => [
                    "success" => false,
                    "code" => $statusCode,
                    'message' => 'All steps of job posting is not completed.',
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now())
                ]
            ];
        }

        return Response::json($response, $statusCode);

    }


}
