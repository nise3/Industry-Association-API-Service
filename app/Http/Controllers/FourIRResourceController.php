<?php

namespace App\Http\Controllers;

use App\Models\FourIRProject;
use App\Models\FourIRResource;
use App\Services\FourIRServices\FourIRFileLogService;
use App\Services\FourIRServices\FourIRResourceService;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class FourIRResourceController extends Controller
{

    public FourIRResourceService $fourIRResourceService;
    public FourIRFileLogService $fourIRFileLogService;
    private Carbon $startTime;

    /**
     * FourIRResourceController constructor.
     *
     * @param FourIRResourceService $fourIRResourceService
     * @param FourIRFileLogService $fourIRFileLogService
     */
    public function __construct(FourIRResourceService $fourIRResourceService, FourIRFileLogService $fourIRFileLogService)
    {
        $this->startTime = Carbon::now();
        $this->fourIRResourceService = $fourIRResourceService;
        $this->fourIRFileLogService = $fourIRFileLogService;
    }


    public function getList(Request $request): JsonResponse
    {
//        $this->authorize('viewAny', FourIRProject::class);

        $filter = $this->fourIRResourceService->filterValidator($request)->validate();
        $response = $this->fourIRResourceService->getFourIRResourceList($filter, $this->startTime);
        return Response::json($response,ResponseAlias::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function read(int $id): JsonResponse
    {
        $guideline = $this->fourIRResourceService->getOneResource($id);
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
     * @throws Throwable
     */
    function store(Request $request): JsonResponse
    {
        //$this->authorize('create', FourIRGuideline::class);
        $validated = $this->fourIRResourceService->validator($request)->validate();
        try {
            DB::beginTransaction();
            $data = $this->fourIRResourceService->store($validated);
            $this->fourIRFileLogService->storeFileLog($data->toArray(), FourIRProject::FILE_LOG_PROJECT_GUIDELINE_STEP);

            DB::commit();
            $response = [
                'data' => $data,
                '_response_status' => [
                    "success" => true,
                    "code" => ResponseAlias::HTTP_CREATED,
                    "message" => "Four Ir Guideline added successfully",
                    "query_time" => $this->startTime->diffInSeconds(Carbon::now())
                ]
            ];
        } catch (Throwable $e){
            DB::rollBack();
            throw $e;
        }

        return Response::json($response, ResponseAlias::HTTP_CREATED);
    }


}
