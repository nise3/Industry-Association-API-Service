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
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getRankList(Request $request, Carbon $startTime): array
    {
        $response=[];
        $titleEn = $request->query('title_en');
        $titleBn = $request->query('title_bn');
        $limit = $request->query('limit', 10);
        $paginate = $request->query('page');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';

        /** @var Builder $rankBuilder */
        $rankBuilder = Rank::select(
            [
                'ranks.id',
                'ranks.title_en',
                'ranks.title_bn',
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
        } elseif (!empty($titleBn)) {
            $rankBuilder->where('ranks.title_bn', 'like', '%' . $titleBn . '%');
        }

        /** @var Collection $ranks */

        if ($paginate) {
            $ranks = $rankBuilder->paginate($limit);
            $paginateData = (object)$ranks->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $ranks = $rankBuilder->get();
        }

        $response['order']=$order;
        $response['data']=$ranks->toArray()['data'] ?? $ranks->toArray();
        $response['response_status']= [
            "success" => true,
            "code" => Response::HTTP_OK,
            "started" => $startTime,
            "finished" => Carbon::now()->format('s'),
        ];

        return $response;
    }

    /**
     * @param int $id
     * @param Carbon $startTime
     * @return array
     */
    public function getOneRank(int $id, Carbon $startTime): array
    {
        /** @var Builder $rankBuilder */
        $rankBuilder = Rank::select(
            [
                'ranks.id',
                'ranks.title_en',
                'ranks.title_bn',
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
        $rankBuilder->where('ranks.id', '=', $id);

        /** @var Rank $rank */
        $rank = $rankBuilder->first();

        return [
            "data" => $rank ?: null,
            "_response_status" => [
                "success" => true,
                "code" => Response::HTTP_OK,
                "started" => $startTime->format('H i s'),
                "finished" => Carbon::now()->format('H i s'),
            ]
        ];
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
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'title_en' => [
                'required',
                'string',
                'max:191',
                'min:2'
            ],
            'title_bn' => [
                'required',
                'string',
                'max:500',
                'min:2'
            ],
            'rank_type_id' => [
                'required',
                'int',
                'exists:rank_types,id',
            ],
            'grade' => [
                'nullable',
                'string',
                'max:100',
            ],
            'display_order' => [
                'nullable',
                'int',
            ],
            'organization_id' => [
                'nullable',
                'int',
                'exists:organizations,id',
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ];
        return Validator::make($request->all(), $rules);
    }
}
