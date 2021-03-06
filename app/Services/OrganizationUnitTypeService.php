<?php

namespace App\Services;

use App\Models\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\OrganizationUnitType;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrganizationUnitTypeService
 * @package App\Services
 */
class OrganizationUnitTypeService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllOrganizationUnitType(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? "";
        $title = $request['title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $organizationId = $request['organization_id'] ?? "";


        /** @var Builder $organizationUnitTypeBuilder */
        $organizationUnitTypeBuilder = OrganizationUnitType::select([
            'organization_unit_types.id',
            'organization_unit_types.title_en',
            'organization_unit_types.title',
            'organization_unit_types.organization_id',
            'organizations.title_en as organization_title_en',
            'organizations.title as organization_title',
            'organization_unit_types.row_status',
            'organization_unit_types.created_by',
            'organization_unit_types.updated_by',
            'organization_unit_types.created_at',
            'organization_unit_types.updated_at',

        ])->acl();

        $organizationUnitTypeBuilder->join('organizations', function ($join) use ($rowStatus) {
            $join->on('organization_unit_types.organization_id', '=', 'organizations.id')
                ->whereNull('organizations.deleted_at');
            /*if (is_numeric($rowStatus)) {
                $join->where('organizations.row_status', $rowStatus);
            }*/
        });

        $organizationUnitTypeBuilder->orderBy('organization_unit_types.id', $order);

        if (is_numeric($rowStatus)) {
            $organizationUnitTypeBuilder->where('organization_unit_types.row_status', $rowStatus);
        }
        if (!empty($titleEn)) {
            $organizationUnitTypeBuilder->where('organization_unit_types.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($title)) {
            $organizationUnitTypeBuilder->where('organization_unit_types.title', 'like', '%' . $title . '%');
        }
        if (is_numeric($organizationId)) {
            $organizationUnitTypeBuilder->where('organization_unit_types.organization_id', $organizationId);
        }

        /** @var Collection $organizationUnitTypes */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $organizationUnitTypes = $organizationUnitTypeBuilder->paginate($pageSize);
            $paginateData = (object)$organizationUnitTypes->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $organizationUnitTypes = $organizationUnitTypeBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $organizationUnitTypes->toArray()['data'] ?? $organizationUnitTypes->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];

        return $response;
    }

    /**
     * @param int $id
     * @return OrganizationUnitType
     */
    public function getOneOrganizationUnitType(int $id): OrganizationUnitType
    {
        /** @var OrganizationUnitType|Builder $organizationUnitTypeBuilder */
        $organizationUnitTypeBuilder = OrganizationUnitType::select([
            'organization_unit_types.id',
            'organization_unit_types.title_en',
            'organization_unit_types.title',
            'organization_unit_types.organization_id',
            'organizations.title_en as organization_title_en',
            'organizations.title as organization_title',
            'organization_unit_types.row_status',
            'organization_unit_types.created_by',
            'organization_unit_types.updated_by',
            'organization_unit_types.created_at',
            'organization_unit_types.updated_at',
        ]);

        $organizationUnitTypeBuilder->join('organizations', function ($join) {
            $join->on('organization_unit_types.organization_id', '=', 'organizations.id')
                ->whereNull('organizations.deleted_at');
        });
        $organizationUnitTypeBuilder->where('organization_unit_types.id', '=', $id);

        return $organizationUnitTypeBuilder->firstOrFail();

    }

    /**
     * @param array $data
     * @return OrganizationUnitType
     */
    public function store(array $data): OrganizationUnitType
    {
        $organizationUnitType = new OrganizationUnitType();
        $organizationUnitType->fill($data);
        $organizationUnitType->save();
        return $organizationUnitType;
    }

    /**
     * @param OrganizationUnitType $organizationUnitType
     * @param array $data
     * @return OrganizationUnitType
     */
    public function update(OrganizationUnitType $organizationUnitType, array $data): OrganizationUnitType
    {
        $organizationUnitType->fill($data);
        $organizationUnitType->save();
        return $organizationUnitType;
    }

    /**
     * @param OrganizationUnitType $organizationUnitType
     * @return bool
     */
    public function destroy(OrganizationUnitType $organizationUnitType): bool
    {
        return $organizationUnitType->delete();
    }

    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllTrashedOrganizationUnitType(Request $request, Carbon $startTime): array
    {
        $titleEn = $request->query('title_en');
        $title = $request->query('title');
        $pageSize = $request->query('pageSize', BaseModel::DEFAULT_PAGE_SIZE);
        $paginate = $request->query('page');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';

        /** @var Builder $organizationUnitTypeBuilder */
        $organizationUnitTypeBuilder = OrganizationUnitType::onlyTrashed()->select([
            'organization_unit_types.id',
            'organization_unit_types.title_en',
            'organization_unit_types.title',
            'organization_unit_types.organization_id',
            'organizations.title_en as organization_name',
            'organization_unit_types.row_status',
            'organization_unit_types.created_by',
            'organization_unit_types.updated_by',
            'organization_unit_types.created_at',
            'organization_unit_types.updated_at',
        ]);
        $organizationUnitTypeBuilder->join('organizations', 'organization_unit_types.organization_id', '=', 'organizations.id');
        $organizationUnitTypeBuilder->orderBy('organization_unit_types.id', $order);

        if (!empty($titleEn)) {
            $organizationUnitTypeBuilder->where('$jobSectors.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($title)) {
            $organizationUnitTypeBuilder->where('job_sectors.title', 'like', '%' . $title . '%');
        }

        /** @var Collection $organizationUnitTypes */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $organizationUnitTypes = $organizationUnitTypeBuilder->paginate($pageSize);
            $paginateData = (object)$organizationUnitTypes->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $organizationUnitTypes = $organizationUnitTypeBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $organizationUnitTypes->toArray()['data'] ?? $organizationUnitTypes->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];

        return $response;
    }

    /**
     * @param OrganizationUnitType $organizationUnitType
     * @return bool
     */
    public function restore(OrganizationUnitType $organizationUnitType): bool
    {
        return $organizationUnitType->restore();
    }

    /**
     * @param OrganizationUnitType $organizationUnitType
     * @return bool
     */
    public function forceDelete(OrganizationUnitType $organizationUnitType): bool
    {
        return $organizationUnitType->forceDelete();
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
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
                'max: 300',
                'min:2'
            ],
            'title' => [
                'required',
                'string',
                'max: 600',
                'min:2',
            ],
            'organization_id' => [
                'required',
                'int',
                'exists:organizations,id,deleted_at,NULL',
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                'nullable',
                Rule::in([OrganizationUnitType::ROW_STATUS_ACTIVE, OrganizationUnitType::ROW_STATUS_INACTIVE]),
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
            'title_en' => 'nullable|max: 300|min:2',
            'title' => 'nullable|max: 600|min:2',
            'page' => 'nullable|integer|gt:0',
            'organization_id' => 'nullable|integer|gt:0',
            'page_size' => 'nullable|integer|gt:0',
            'order' => [
                'nullable',
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                'nullable',
                "integer",
                Rule::in([OrganizationUnitType::ROW_STATUS_ACTIVE, OrganizationUnitType::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }
}
