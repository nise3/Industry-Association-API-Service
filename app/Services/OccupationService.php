<?php

namespace App\Services;

use App\Models\BaseModel;
use App\Models\Occupation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OccupationService
 * @package App\Services
 */
class OccupationService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getOccupationList(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? "";
        $title = $request['title'] ?? "";
        $author = $request['author'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $jobSectorId = $request['job_sector_id'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";


        /** @var Builder $occupationBuilder */
        $occupationBuilder = Occupation::select([
            'occupations.id',
            'occupations.title_en',
            'occupations.title',
            'occupations.job_sector_id',
            'job_sectors.title_en as job_sector_title_en',
            'job_sectors.title as job_sector_title',
            'occupations.row_status',
            'occupations.created_by',
            'occupations.updated_by',
            'occupations.created_at',
            'occupations.updated_at',
        ]);

        $occupationBuilder->orderBy('occupations.id', $order);

        $occupationBuilder->join('job_sectors', function ($join) use ($rowStatus) {
            $join->on('occupations.job_sector_id', '=', 'job_sectors.id')
                ->whereNull('job_sectors.deleted_at');
        });

        if (is_numeric($rowStatus)) {
            $occupationBuilder->where('occupations.row_status', $rowStatus);
        }
        if (is_numeric($jobSectorId)) {
            $occupationBuilder->where('occupations.job_sector_id', $jobSectorId);
        }
        if (!empty($titleEn)) {
            $occupationBuilder->where('occupations.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($title)) {
            $occupationBuilder->where('occupations.title', 'like', '%' . $title . '%');
        }
        if (!empty($author)) {
            $occupationBuilder->where('occupations.author', 'like', '%' . $author . '%');
        }

        /** @var Collection $occupations */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $occupations = $occupationBuilder->paginate($pageSize);
            $paginateData = (object)$occupations->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $occupations = $occupationBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $occupations->toArray()['data'] ?? $occupations->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];

        return $response;
    }

    /**
     * @param $id
     * @return Occupation
     */
    public function getOneOccupation($id): Occupation
    {
        /** @var Occupation|Builder $occupationBuilder */
        $occupationBuilder = Occupation::select([
            'occupations.id',
            'occupations.title_en',
            'occupations.title',
            'occupations.job_sector_id',
            'job_sectors.title_en as job_sector_title_en',
            'job_sectors.title as job_sector_title',
            'occupations.row_status',
            'occupations.created_by',
            'occupations.updated_by',
            'occupations.created_at',
            'occupations.updated_at',
        ]);
        $occupationBuilder->join('job_sectors', function ($join) {
            $join->on('occupations.job_sector_id', '=', 'job_sectors.id')
                ->whereNull('job_sectors.deleted_at');
        });
        $occupationBuilder->where('occupations.id', '=', $id);


        return $occupationBuilder->firstOrFail();
    }

    /**
     * @param array $data
     * @return Occupation
     */
    public function store(array $data): Occupation
    {
        $occupation = new Occupation();
        $occupation->fill($data);
        $occupation->save();
        return $occupation;
    }

    /**
     * @param Occupation $occupation
     * @param array $data
     * @return Occupation
     */
    public function update(Occupation $occupation, array $data): Occupation
    {
        $occupation->fill($data);
        $occupation->save();
        return $occupation;
    }

    /**
     * @param Occupation $occupation
     * @return bool
     */
    public function destroy(Occupation $occupation): bool
    {
        return $occupation->delete();
    }

    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getTrashedOccupationList(Request $request, Carbon $startTime): array
    {
        $titleEn = $request->query('title_en');
        $title = $request->query('title');
        $page_size = $request->query('page_size', BaseModel::DEFAULT_PAGE_SIZE);
        $paginate = $request->query('page');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';

        /** @var Builder $occupationBuilder */
        $occupationBuilder = Occupation::onlyTrashed()->select([
            'occupations.id',
            'occupations.title_en',
            'occupations.title',
            'occupations.job_sector_id',
            'job_sectors.title_en as job_sector_title',
            'occupations.row_status',
            'occupations.created_by',
            'occupations.updated_by',
            'occupations.created_at',
            'occupations.updated_at',
        ]);
        $occupationBuilder->join('job_sectors', 'occupations.job_sector_id', '=', 'job_sectors.id');
        $occupationBuilder->orderBy('occupations.id', $order);

        if (!empty($titleEn)) {
            $occupationBuilder->where('occupations.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($title)) {
            $occupationBuilder->where('occupations.title', 'like', '%' . $title . '%');
        }

        /** @var Collection $occupations */

        if (is_numeric($paginate) || is_numeric($page_size)) {
            $page_size = $page_size ?: BaseModel::DEFAULT_PAGE_SIZE;
            $occupations = $occupationBuilder->paginate($page_size);
            $paginateData = (object)$occupations->toArray();

            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $occupations = $occupationBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $occupations->toArray()['data'] ?? $occupations->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];

        return $response;
    }

    /**
     * @param Occupation $occupation
     * @return bool
     */
    public function restore(Occupation $occupation): bool
    {
        return $occupation->restore();
    }

    /**
     * @param Occupation $occupation
     * @return bool
     */
    public function forceDelete(Occupation $occupation): bool
    {
        return $occupation->forceDelete();
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
                'max:400',
                'min:2',
            ],
            'title' => [
                'required',
                'string',
                'max:800',
                'min:2'
            ],
            'job_sector_id' => [
                'required',
                'integer',
                'exists:job_sectors,id,deleted_at,NULL',
            ],
            'row_status' => [
                'required_if:' . $id . ',!=,null',
                'nullable',
                Rule::in([Occupation::ROW_STATUS_ACTIVE, Occupation::ROW_STATUS_INACTIVE]),
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
            'title_en' => 'nullable|max:400|min:2',
            'title' => 'nullable|max:800|min:2',
            'page' => 'nullable|integer|gt:0',
            'job_sector_id' => 'nullable|integer|gt:0',
            'page_size' => 'nullable|integer|gt:0',
            'order' => [
                'nullable',
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                'nullable',
                "integer",
                Rule::in([Occupation::ROW_STATUS_ACTIVE, Occupation::ROW_STATUS_INACTIVE]),
            ],
        ], $customMessage);
    }
}
