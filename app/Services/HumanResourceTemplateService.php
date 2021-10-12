<?php

namespace App\Services;

use App\Models\BaseModel;
use App\Models\HumanResourceTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HumanResourceTemplateService
 * @package App\Services
 */
class HumanResourceTemplateService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getHumanResourceTemplateList(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? "";
        $title = $request['title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $organizationId = $request['organization_id'] ?? "";
        $organizationUnitTypeId = $request['organization_unit_type_id'] ?? "";


        /** @var Builder $humanResourceTemplateBuilder */
        $humanResourceTemplateBuilder = HumanResourceTemplate::select([
            'human_resource_templates.id',
            'human_resource_templates.title_en',
            'human_resource_templates.title',
            'human_resource_templates.display_order',
            'human_resource_templates.is_designation',
            'human_resource_templates.parent_id',
            'human_res_tem_2.title_en as parent_title_en',
            'human_res_tem_2.title as parent_title',
            'human_resource_templates.organization_id',
            'organizations.title_en as organization_title_en',
            'organizations.title as organization_title',
            'human_resource_templates.organization_unit_type_id',
            'organization_unit_types.title_en as organization_unit_type_title_en',
            'organization_unit_types.title as organization_unit_type_title',
            'human_resource_templates.rank_id',
            'ranks.title_en as rank_title_en',
            'ranks.title as rank_title',
            'human_resource_templates.status',
            'human_resource_templates.row_status',
            'human_resource_templates.created_by',
            'human_resource_templates.updated_by',
            'human_resource_templates.created_at',
            'human_resource_templates.updated_at',

        ]);

        $humanResourceTemplateBuilder->join('organizations', function ($join) use ($rowStatus) {
            $join->on('human_resource_templates.organization_id', '=', 'organizations.id')
                ->whereNull('organizations.deleted_at');
            if (is_int($rowStatus)) {
                $join->where('organizations.row_status', $rowStatus);
            }
        });
        $humanResourceTemplateBuilder->join('organization_unit_types', function ($join) use ($rowStatus) {
            $join->on('human_resource_templates.organization_unit_type_id', '=', 'organization_unit_types.id')
                ->whereNull('organization_unit_types.deleted_at');
            if (is_int($rowStatus)) {
                $join->where('organization_unit_types.row_status', $rowStatus);
            }
        });
        $humanResourceTemplateBuilder->leftJoin('ranks', function ($join) use ($rowStatus) {
            $join->on('human_resource_templates.rank_id', '=', 'ranks.id')
                ->whereNull('ranks.deleted_at');
            if (is_int($rowStatus)) {
                $join->where('ranks.row_status', $rowStatus);
            }
        });
        $humanResourceTemplateBuilder->leftJoin('human_resource_templates as human_res_tem_2', function ($join) use ($rowStatus) {
            $join->on('human_resource_templates.parent_id', '=', 'human_res_tem_2.id')
                ->whereNull('human_res_tem_2.deleted_at');
            if (is_int($rowStatus)) {
                $join->where('human_res_tem_2.row_status', $rowStatus);
            }
        });

        $humanResourceTemplateBuilder->orderBy('human_resource_templates.id', $order);

        if (is_int($rowStatus)) {
            $humanResourceTemplateBuilder->where('human_resource_templates.row_status', $rowStatus);
        }

        if (is_int($organizationId)) {
            $humanResourceTemplateBuilder->where('human_resource_templates.organization_id', $organizationId);
        }

        if (is_int($organizationUnitTypeId)) {
            $humanResourceTemplateBuilder->where('human_resource_templates.organization_unit_type_id', $organizationUnitTypeId);
        }

        if (!empty($titleEn)) {
            $humanResourceTemplateBuilder->where('human_resource_templates.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($title)) {
            $humanResourceTemplateBuilder->where('human_resource_templates.title', 'like', '%' . $title . '%');
        }

        /** @var Collection $humanResourceTemplates */

        if (is_int($paginate) || is_int($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $humanResourceTemplates = $humanResourceTemplateBuilder->paginate($pageSize);
            $paginateData = (object)$humanResourceTemplates->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $humanResourceTemplates = $humanResourceTemplateBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $humanResourceTemplates->toArray()['data'] ?? $humanResourceTemplates->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now()),
        ];

        return $response;
    }

    /**
     * @param int $id
     * @param Carbon $startTime
     * @return array
     */
    public function getOneHumanResourceTemplate(int $id, Carbon $startTime): array
    {
        /** @var Builder $humanResourceTemplateBuilder */
        $humanResourceTemplateBuilder = HumanResourceTemplate::select([
            'human_resource_templates.id',
            'human_resource_templates.title_en',
            'human_resource_templates.title',
            'human_resource_templates.display_order',
            'human_resource_templates.is_designation',
            'human_resource_templates.parent_id',
            'human_res_tem_2.title_en as parent_title_en',
            'human_res_tem_2.title as parent_title',
            'human_resource_templates.organization_id',
            'organizations.title_en as organization_title_en',
            'organizations.title as organization_title',
            'human_resource_templates.organization_unit_type_id',
            'organization_unit_types.title_en as organization_unit_type_title_en',
            'organization_unit_types.title as organization_unit_type_title',
            'human_resource_templates.rank_id',
            'ranks.title_en as rank_title_en',
            'ranks.title as rank_title',
            'human_resource_templates.status',
            'human_resource_templates.row_status',
            'human_resource_templates.created_by',
            'human_resource_templates.updated_by',
            'human_resource_templates.created_at',
            'human_resource_templates.updated_at',
        ]);
        $humanResourceTemplateBuilder->join('organizations', function ($join) {
            $join->on('human_resource_templates.organization_id', '=', 'organizations.id')
                ->whereNull('organizations.deleted_at');

        });
        $humanResourceTemplateBuilder->join('organization_unit_types', function ($join) {
            $join->on('human_resource_templates.organization_unit_type_id', '=', 'organization_unit_types.id')
                ->whereNull('organization_unit_types.deleted_at');

        });
        $humanResourceTemplateBuilder->leftJoin('ranks', function ($join) {
            $join->on('human_resource_templates.rank_id', '=', 'ranks.id')
                ->whereNull('ranks.deleted_at');
        });
        $humanResourceTemplateBuilder->leftJoin('human_resource_templates as human_res_tem_2', function ($join) {
            $join->on('human_resource_templates.parent_id', '=', 'human_res_tem_2.id')
                ->whereNull('human_res_tem_2.deleted_at');
        });

        $humanResourceTemplateBuilder->where('human_resource_templates.id', $id);

        /** @var HumanResourceTemplate $humanResourceTemplate */
        $humanResourceTemplate = $humanResourceTemplateBuilder->first();

        return [
            "data" => $humanResourceTemplate ?: [],
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "query_time" => $startTime->diffInSeconds(Carbon::now()),
            ]
        ];
    }

    /**
     * create a human resource template data
     * @param array $data
     * @return HumanResourceTemplate
     */
    public function store(array $data): HumanResourceTemplate
    {
        $humanResourceTemplate = new HumanResourceTemplate();
        $humanResourceTemplate->fill($data);
        $humanResourceTemplate->save();
        return $humanResourceTemplate;
    }

    /**
     * @param HumanResourceTemplate $humanResourceTemplate
     * @param array $data
     * @return HumanResourceTemplate
     */
    public function update(HumanResourceTemplate $humanResourceTemplate, array $data): HumanResourceTemplate
    {
        $humanResourceTemplate->fill($data);
        $humanResourceTemplate->save();
        return $humanResourceTemplate;
    }

    /**
     * @param HumanResourceTemplate $humanResourceTemplate
     * @return bool
     */
    public function destroy(HumanResourceTemplate $humanResourceTemplate): bool
    {
        return $humanResourceTemplate->delete();
    }

    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getTrashedHumanResourceTemplateList(Request $request, Carbon $startTime): array
    {
        $titleEn = $request->query('title_en');
        $title = $request->query('title');
        $pageSize = $request->query('page_size', 10);
        $paginate = $request->query('page');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';

        /** @var Builder $humanResourceTemplateBuilder */
        $humanResourceTemplateBuilder = HumanResourceTemplate::onlyTrashed()->select([
            'human_resource_templates.id',
            'human_resource_templates.title_en',
            'human_resource_templates.title',
            'human_resource_templates.display_order',
            'human_resource_templates.is_designation',
            'human_resource_templates.parent_id',
            'human_res_tem_2.title_en as parent_title_en',
            'human_res_tem_2.title as parent_title',
            'human_resource_templates.organization_id',
            'organizations.title_en as organization_title',
            'human_resource_templates.organization_unit_type_id',
            'organization_unit_types.title_en as organization_unit_type_title',
            'human_resource_templates.rank_id',
            'ranks.title_en as rank_title_en',
            'human_resource_templates.status',
            'human_resource_templates.row_status',
            'human_resource_templates.created_by',
            'human_resource_templates.updated_by',
            'human_resource_templates.created_at',
            'human_resource_templates.updated_at',
        ]);

        $humanResourceTemplateBuilder->join('organizations', 'human_resource_templates.organization_id', '=', 'organizations.id');
        $humanResourceTemplateBuilder->join('organization_unit_types', 'human_resource_templates.organization_unit_type_id', '=', 'organization_unit_types.id');
        $humanResourceTemplateBuilder->leftJoin('ranks', 'human_resource_templates.rank_id', '=', 'ranks.id');
        $humanResourceTemplateBuilder->leftJoin('human_resource_templates as human_res_tem_2', 'human_resource_templates.parent_id', '=', 'human_res_tem_2.id');
        $humanResourceTemplateBuilder->orderBy('human_resource_templates.id', $order);

        if (!empty($titleEn)) {
            $humanResourceTemplateBuilder->where('human_resource_templates.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($title)) {
            $humanResourceTemplateBuilder->where('human_resource_templates.title', 'like', '%' . $title . '%');
        }

        /** @var Collection $humanResourceTemplates */

        if (!is_int($paginate) || !is_int($pageSize)) {
            $pageSize = $pageSize ?: 10;
            $humanResourceTemplates = $humanResourceTemplateBuilder->paginate($pageSize);
            $paginateData = (object)$humanResourceTemplates->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $humanResourceTemplates = $humanResourceTemplateBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $humanResourceTemplates->toArray()['data'] ?? $humanResourceTemplates->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now()),
        ];

        return $response;
    }

    /**
     * @param HumanResourceTemplate $humanResourceTemplate
     * @return bool
     */
    public function restore(HumanResourceTemplate $humanResourceTemplate): bool
    {
        return $humanResourceTemplate->restore();
    }

    /**
     * @param HumanResourceTemplate $humanResourceTemplate
     * @return bool
     */
    public function forceDelete(HumanResourceTemplate $humanResourceTemplate): bool
    {
        return $humanResourceTemplate->forceDelete();
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];
        $rules = [
            'title_en' => [
                'nullable',
                'string',
                'max: 400',
                'min: 2'
            ],
            'title' => [
                'required',
                'string',
                'max: 800',
                'min: 2'
            ],
            'organization_id' => [
                'exists:organizations,id',
                'required',
                'integer'

            ],
            'organization_unit_type_id' => [
                'exists:organization_unit_types,id',
                'required',
                'integer'
            ],
            'parent_id' => [
                'exists:human_resource_templates,id',
                'nullable',
                'integer'
            ],
            'rank_id' => [
                'exists:ranks,id',
                'nullable',
                'integer'
            ],
            'display_order' => [
                'required',
                'integer',
                'min:0'
            ],
            'is_designation' => [
                'required',
                'integer'
            ],
            'status' => [
                'integer',
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                'integer',
                Rule::in([HumanResourceTemplate::ROW_STATUS_ACTIVE, HumanResourceTemplate::ROW_STATUS_INACTIVE]),
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
            'order.in' => [
                'code' => 30000,
                "message" => 'Order must be within ASC or DESC',
            ],
            'row_status.in' => [
                'code' => 30000,
                'message' => 'Row status must be within 1 or 0'
            ]
        ];

        if (!empty($request['order'])) {
            $request['order'] = strtoupper($request['order']);
        }

        return Validator::make($request->all(), [
            'title_en' => 'nullable|max:400|min:2',
            'title' => 'nullable|max:800|min:2',
            'page' => 'integer|gt:0',
            'page_size' => 'integer|gt:0',
            'organization_id' => 'exists:organizations,id|integer',
            'organization_unit_type_id' => 'exists:organization_unit_types,id|integer',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "integer",
                Rule::in([HumanResourceTemplate::ROW_STATUS_ACTIVE, HumanResourceTemplate::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }
}

