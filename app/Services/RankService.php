<?php


namespace App\Services;

use App\Models\BaseModel;
use App\Models\Rank;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class RankService
 * @package App\Services
 */
class RankService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getRankList(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? "";
        $title = $request['title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $organizationId = $request['organization_id'] ?? "";

        /** @var Builder $rankBuilder */
        $rankBuilder = Rank::select(
            [
                'ranks.id',
                'ranks.title_en',
                'ranks.title',
                'ranks.grade',
                'ranks.display_order',
                'ranks.organization_id',
                'organizations.title_en as organization_title_en',
                'organizations.title as organization_title',
                'rank_types.id as rank_type_id',
                'rank_types.title_en as rank_type_title_en',
                'rank_types.title as rank_type_title',
                'ranks.row_status',
                'ranks.created_by',
                'ranks.updated_by',
                'ranks.created_at',
                'ranks.updated_at',
            ]
        )->acl();

        $rankBuilder->leftJoin('organizations', function ($join) use ($rowStatus) {
            $join->on('ranks.organization_id', '=', 'organizations.id')
                ->whereNull('organizations.deleted_at');
            /*if (is_numeric($rowStatus)) {
                $join->where('organizations.row_status', $rowStatus);
            }*/
        });
        $rankBuilder->join('rank_types', function ($join) use ($rowStatus) {
            $join->on('ranks.rank_type_id', '=', 'rank_types.id')
                ->whereNull('rank_types.deleted_at');
            if (is_numeric($rowStatus)) {
                $join->where('ranks.row_status', $rowStatus);
            }
        });
        $rankBuilder->orderBy('ranks.id', $order);


        if (is_numeric($rowStatus)) {
            $rankBuilder->where('ranks.row_status', $rowStatus);
        }
        if (is_numeric($organizationId)) {
            $rankBuilder->where('ranks.organization_id', $organizationId);
        }
        if (!empty($titleEn)) {
            $rankBuilder->where('ranks.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($title)) {
            $rankBuilder->where('ranks.title', 'like', '%' . $title . '%');
        }

        /** @var Collection $ranks */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $ranks = $rankBuilder->paginate($pageSize);
            $paginateData = (object)$ranks->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $ranks = $rankBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $ranks->toArray()['data'] ?? $ranks->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];

        return $response;
    }

    /**
     * @param int $id
     * @return Rank
     */
    public function getOneRank(int $id): Rank
    {
        /** @var Rank|Builder $rankBuilder */
        $rankBuilder = Rank::select(
            [
                'ranks.id',
                'ranks.title_en',
                'ranks.title',
                'ranks.grade',
                'ranks.display_order',
                'ranks.organization_id',
                'organizations.title_en as organization_title_en',
                'organizations.title as organization_title',
                'rank_types.id as rank_type_id',
                'rank_types.title_en as rank_type_title_en',
                'rank_types.title as rank_type_title',
                'ranks.row_status',
                'ranks.created_by',
                'ranks.updated_by',
                'ranks.created_at',
                'ranks.updated_at',
            ]
        );
        $rankBuilder->leftJoin('organizations', function ($join) {
            $join->on('ranks.organization_id', '=', 'organizations.id')
                ->whereNull('organizations.deleted_at');
        });
        $rankBuilder->join('rank_types', function ($join) {
            $join->on('ranks.rank_type_id', '=', 'rank_types.id')
                ->whereNull('rank_types.deleted_at');
        });
        $rankBuilder->where('ranks.id', '=', $id);

        return $rankBuilder->firstOrFail();
    }

    /**
     * @param array $data
     * @return Rank
     */
    public function store(array $data): Rank
    {
        $rank = new Rank();
        $rank->fill($data);
        $rank->save();
        return $rank;
    }

    /**
     * @param Rank $rank
     * @param array $data
     * @return Rank
     */
    public function update(Rank $rank, array $data): Rank
    {
        $rank->fill($data);
        $rank->save();
        return $rank;
    }

    /**
     * @param Rank $rank
     * @return bool
     */
    public function destroy(Rank $rank): bool
    {
        return $rank->delete();
    }

    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getTrashedRankList(Request $request, Carbon $startTime): array
    {
        $titleEn = $request->query('title_en');
        $title = $request->query('title');
        $pageSize = $request->query('pageSize', BaseModel::DEFAULT_PAGE_SIZE);
        $paginate = $request->query('page');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';

        /** @var Builder $rankBuilder */
        $rankBuilder = Rank::onlyTrashed()->select(
            [
                'ranks.id',
                'ranks.title_en',
                'ranks.title',
                'ranks.grade',
                'ranks.display_order',
                'ranks.organization_id',
                'organizations.title_en as organization_title_en',
                'rank_types.id as rank_type_id',
                'rank_types.title_en as rank_type_title_en',
                'ranks.row_status',
                'ranks.created_by',
                'ranks.updated_by',
                'ranks.created_at',
                'ranks.updated_at',
            ]
        );
        $rankBuilder->leftJoin('organizations', 'ranks.organization_id', '=', 'organizations.id');
        $rankBuilder->join('rank_types', 'ranks.rank_type_id', '=', 'rank_types.id');
        $rankBuilder->orderBy('ranks.id', $order);


        if (!empty($titleEn)) {
            $rankBuilder->where('ranks.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($title)) {
            $rankBuilder->where('ranks.title', 'like', '%' . $title . '%');
        }

        /** @var Collection $ranks */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $ranks = $rankBuilder->paginate($pageSize);
            $paginateData = (object)$ranks->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $ranks = $rankBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $ranks->toArray()['data'] ?? $ranks->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];

        return $response;
    }

    /**
     * @param Rank $rank
     * @return bool
     */
    public function restore(Rank $rank): bool
    {
        return $rank->restore();
    }

    /**
     * @param Rank $rank
     * @return bool
     */
    public function forceDelete(Rank $rank): bool
    {
        return $rank->forceDelete();
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
                'max:300',
                'min:2'
            ],
            'title' => [
                'required',
                'string',
                'max:600',
                'min:2'
            ],
            'rank_type_id' => [
                'exists:rank_types,id,deleted_at,NULL',
                'required',
                'int'
            ],
            'grade' => [
                'nullable',
                'string',
                'max:100',
            ],
            'display_order' => [
                'nullable',
                'integer',
            ],
            'organization_id' => [
                'required',
                'exists:organizations,id,deleted_at,NULL',
                'int'
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                'nullable',
                Rule::in([Rank::ROW_STATUS_ACTIVE, Rank::ROW_STATUS_INACTIVE]),
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
            'title_en' => 'nullable|max:300|min:2',
            'title' => 'nullable|max:600|min:2',
            'page' => 'nullable|integer|gt:0',
            'page_size' => 'nullable|integer|gt:0',
            'organization_id' => 'nullable||integer|gt:0',
            'order' => [
                'nullable',
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                'nullable',
                "integer",
                Rule::in([Rank::ROW_STATUS_ACTIVE, Rank::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }
}
