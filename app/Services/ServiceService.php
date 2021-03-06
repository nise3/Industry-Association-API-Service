<?php

namespace App\Services;

use App\Models\BaseModel;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ServiceService
 * @package App\Services
 */
class ServiceService
{

    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getServiceList(array $request, Carbon $startTime): array
    {

        $titleEn = $request['title_en'] ?? "";
        $title = $request['title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";

        /** @var Builder $serviceBuilder */
        $serviceBuilder = Service::select(
            [
                'services.id',
                'services.title_en',
                'services.title',
                'services.row_status',
                'services.created_by',
                'services.updated_by',
                'services.created_at',
                'services.updated_at',
            ]
        );
        $serviceBuilder->orderBy('services.id', $order);

        if (is_numeric($rowStatus)) {
            $serviceBuilder->where('services.row_Status', $rowStatus);
        }
        if (!empty($titleEn)) {
            $serviceBuilder->where('services.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($title)) {
            $serviceBuilder->where('services.title', 'like', '%' . $title . '%');
        }

        /** @var Collection $services */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $services = $serviceBuilder->paginate($pageSize);
            $paginateData = (object)$services->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $services = $serviceBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $services->toArray()['data'] ?? $services->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];

        return $response;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getOneService(int $id): Service
    {
        /** @var Service|Builder $serviceBuilder */
        $serviceBuilder = Service::select(
            [
                'services.id',
                'services.title_en',
                'services.title',
                'services.row_status',
                'services.created_by',
                'services.updated_by',
                'services.created_at',
                'services.updated_at',
            ]
        );
        $serviceBuilder->where('services.id', '=', $id);

        return $serviceBuilder->firstOrFail();
    }

    /**
     * @param array $data
     * @return Service
     */
    public function store(array $data): Service
    {
        $service = new Service();
        $service->fill($data);
        $service->save();
        return $service;
    }

    /**
     * @param Service $service
     * @param array $data
     * @return Service
     */
    public function update(Service $service, array $data): Service
    {
        $service->fill($data);
        $service->save();
        return $service;
    }

    /**
     * @param Service $service
     * @return bool
     */
    public function destroy(Service $service): bool
    {
        return $service->delete();
    }

    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getTrashedServiceList(Request $request, Carbon $startTime): array
    {
        $titleEn = $request->query('title_en');
        $title = $request->query('title');
        $pageSize = $request->query('page_size', BaseModel::DEFAULT_PAGE_SIZE);
        $paginate = $request->query('page');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';

        /** @var Builder $serviceBuilder */
        $serviceBuilder = Service::onlyTrashed()->select(
            [
                'services.id as id',
                'services.title_en',
                'services.title',
                'services.row_status',
                'services.created_by',
                'services.updated_by',
                'services.created_at',
                'services.updated_at',
            ]
        );
        $serviceBuilder->orderBy('services.id', $order);

        if (!empty($organizationId)) {
            $serviceBuilder->where('services.organization_id', '=', $organizationId);
        }
        if (!empty($titleEn)) {
            $serviceBuilder->where('services.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($title)) {
            $serviceBuilder->where('services.title', 'like', '%' . $title . '%');
        }

        /** @var Collection $services */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $services = $serviceBuilder->paginate($pageSize);
            $paginateData = (object)$services->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $services = $serviceBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $services->toArray()['data'] ?? $services->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];

        return $response;
    }

    /**
     * @param Service $service
     * @return bool
     */
    public function restore(Service $service): bool
    {
        return $service->restore();
    }

    /**
     * @param Service $service
     * @return bool
     */
    public function forceDelete(Service $service): bool
    {
        return $service->forceDelete();
    }

    /**
     * @param Request $request
     * return use Illuminate\Support\Facades\Validator;
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
        ];
        $rules = [
            'title_en' => [
                'nullable',
                'string',
                'max:500',
                'min:2',
            ],
            'title' => [
                'required',
                'string',
                'max: 1000',
                'min:2',
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                'nullable',
                Rule::in([Service::ROW_STATUS_ACTIVE, Service::ROW_STATUS_INACTIVE]),
            ],
        ];
        return Validator::make($request->all(), $rules, $customMessage);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function filterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'order.in' => 'Order must be within ASC or DESC.[30000]',
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
        ];

        if ($request->filled('order')) {
            $request->offsetSet('order', strtoupper($request->get('order')));
        }

        return Validator::make($request->all(), [
            'title_en' => 'nullable|max:500|min:2',
            'title' => 'nullable|max:1000|min:2',
            'page' => 'nullable|integer|gt:0',
            'page_size' => 'nullable|integer|gt:0',
            'order' => [
                'nullable',
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                'nullable',
                "integer",
                Rule::in([Service::ROW_STATUS_ACTIVE, Service::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }
}
