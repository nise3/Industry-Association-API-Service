<?php

namespace App\Http\Controllers;

use App\Models\FourIRInitiative;
use App\Models\FourIRAssessment;
use App\Services\FourIRServices\FourIRFileLogService;
use App\Services\FourIRServices\FourIRAssessmentService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class FourIRAssessmentController extends Controller
{
    public FourIRAssessmentService $fourIRAssessmentService;
    public FourIRFileLogService $fourIRFileLogService;

    private Carbon $startTime;

    /**
     * @param FourIRAssessmentService $fourIRAssessmentService
     * @param FourIRFileLogService $fourIRFileLogService
     */
    public function __construct(FourIRAssessmentService $fourIRAssessmentService, FourIRFileLogService $fourIRFileLogService)
    {
        $this->startTime = Carbon::now();
        $this->fourIRAssessmentService = $fourIRAssessmentService;
        $this->fourIRFileLogService = $fourIRFileLogService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable|ValidationException
     */
    public function getList(Request $request): JsonResponse
    {

        $filter = $this->fourIRAssessmentService->filterValidator($request)->validate();
        $response = $this->fourIRAssessmentService->getFourIrAssessmentList($filter, $this->startTime);
        return Response::json($response, ResponseAlias::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function read(int $id): JsonResponse
    {
        $fourIRAssessment = $this->fourIRAssessmentService->getOneFourIrAssessment($id);
        $response = [
            "data" => $fourIRAssessment,
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
     * @throws Throwable|ValidationException
     */
    function store(Request $request): JsonResponse
    {
        $validated = $this->fourIRAssessmentService->validator($request)->validate();
        try {
            DB::beginTransaction();
            $data = $this->fourIRAssessmentService->store($validated);
            $this->fourIRFileLogService->storeFileLog($data->toArray(), FourIRInitiative::FILE_LOG_ASSESSMENT_STEP);

            DB::commit();
            $response = [
                'data' => $data,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "Four Ir Assessment  added successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now())
                ]
            ];
        } catch (Throwable $e){
            DB::rollBack();
            throw $e;
        }

        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     * @throws Throwable
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $fourIrAssessment = FourIRAssessment::findOrFail($id);
        $validated = $this->fourIRAssessmentService->validator($request, $id)->validate();
        try {
            DB::beginTransaction();
            $filePath = $fourIrAssessment['file_path'];
            $data = $this->fourIRAssessmentService->update($fourIrAssessment, $validated);
            $this->fourIRFileLogService->updateFileLog($filePath, $data->toArray(), FourIRInitiative::FILE_LOG_ASSESSMENT_STEP);

            DB::commit();
            $response = [
                'data' => $data,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_OK,
                    "message" => "Four Ir Assessment updated successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now())
                ]
            ];
        } catch (Throwable $e){
            DB::rollBack();
            throw $e;
        }

        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $fourIrAssessment = FourIRAssessment::findOrFail($id);
        $this->fourIRAssessmentService->destroy($fourIrAssessment);
        $response = [
            '_response_status' => [
                "success" => true,
                "code" => ResponseAlias::HTTP_OK,
                "message" => "Four Ir Assessment deleted successfully",
                "query_time" => $this->startTime->diffInSeconds(Carbon::now())
            ]
        ];
        return Response::json($response, ResponseAlias::HTTP_OK);
    }
}