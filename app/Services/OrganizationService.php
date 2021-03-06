<?php

namespace App\Services;

use App\Exceptions\HttpErrorException;
use App\Models\AppliedJob;
use App\Models\BaseModel;
use App\Models\CandidateRequirement;
use App\Models\HrDemand;
use App\Models\IndustryAssociation;
use App\Models\NascibMember;
use App\Models\PaymentTransactionHistory;
use App\Models\PrimaryJobInformation;
use App\Models\SmefMember;
use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrganizationService
 * @package App\Services
 */
class OrganizationService
{
    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllOrganization(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? "";
        $title = $request['title'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $organizationTypeId = $request['organization_type_id'] ?? "";


        /** @var Builder organizationBuilder */
        $organizationBuilder = Organization::select([
            'organizations.id',
            'organizations.title_en',
            'organizations.title',
            'organizations.date_of_establishment',
            'organizations.name_of_the_office_head',
            'organizations.name_of_the_office_head_en',
            'organizations.name_of_the_office_head_designation',
            'organizations.name_of_the_office_head_designation_en',
            'organizations.domain',
            'organizations.fax_no',
            'organizations.mobile',
            'organizations.email',
            'organizations.contact_person_name',
            'organizations.contact_person_name_en',
            'organizations.contact_person_mobile',
            'organizations.contact_person_email',
            'organizations.contact_person_designation',
            'organizations.contact_person_designation_en',
            'organizations.description',
            'organizations.description_en',
            'organizations.logo',
            'organizations.loc_division_id',
            'loc_divisions.title_en as loc_division_title_en',
            'loc_divisions.title as loc_division_title',
            'organizations.loc_district_id',
            'loc_districts.title_en as loc_district_title_en',
            'loc_districts.title as loc_district_title',
            'organizations.loc_upazila_id',
            'loc_upazilas.title_en as loc_upazila_title_en',
            'loc_upazilas.title as loc_upazila_title',
            'organizations.organization_type_id',
            'organization_types.title_en as organization_type_title_en',
            'organization_types.title as organization_type_title',
            'organizations.address',
            'organizations.address_en',
            'organizations.row_status',
            'organizations.created_by',
            'organizations.updated_by',
            'organizations.created_at',
            'organizations.updated_at'

        ])->acl();

        $organizationBuilder->join('organization_types', function ($join) use ($rowStatus) {
            $join->on('organizations.organization_type_id', '=', 'organization_types.id')
                ->whereNull('organization_types.deleted_at');
            /*if (is_numeric($rowStatus)) {
                $join->where('organization_types.row_status', $rowStatus);
            }*/
        });
        $organizationBuilder->leftjoin('loc_divisions', function ($join) use ($rowStatus) {
            $join->on('organizations.loc_division_id', '=', 'loc_divisions.id')
                ->whereNull('loc_divisions.deleted_at');
        });
        $organizationBuilder->leftjoin('loc_districts', function ($join) use ($rowStatus) {
            $join->on('organizations.loc_district_id', '=', 'loc_districts.id')
                ->whereNull('loc_districts.deleted_at');
        });
        $organizationBuilder->leftjoin('loc_upazilas', function ($join) use ($rowStatus) {
            $join->on('organizations.loc_upazila_id', '=', 'loc_upazilas.id')
                ->whereNull('loc_upazilas.deleted_at');
        });

        $organizationBuilder->orderBy('organizations.id', $order);

        if (is_numeric($rowStatus)) {
            $organizationBuilder->where('organizations.row_status', $rowStatus);
        }

        if (is_numeric($organizationTypeId)) {
            $organizationBuilder->where('organizations.organization_type_id', $organizationTypeId);
        }

        if (!empty($titleEn)) {
            $organizationBuilder->where('organizations.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($title)) {
            $organizationBuilder->where('organizations.title', 'like', '%' . $title . '%');
        }

        /** @var Collection $organizations */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $organizations = $organizationBuilder->paginate($pageSize);
            $paginateData = (object)$organizations->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $organizations = $organizationBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $organizations->toArray()['data'] ?? $organizations->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];

        return $response;
    }

    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getOrganizationListByIndustryAssociation(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? "";
        $title = $request['title'] ?? "";
        $searchText = $request['search_text'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $rowStatus = $request['row_status'] ?? "";
        $order = $request['order'] ?? "ASC";
        $membershipId = $request['membership_id'] ?? "";
        $industryAssociationId = $request['industry_association_id'] ?? "";
        /** No need to add this filter in api doc,will come with request  */


        $organizationBuilder = Organization::select(
            [
                'organizations.id',
                'organizations.title_en',
                'organizations.title',
                'organizations.date_of_establishment',
                'industry_association_organization.membership_id',
                'organizations.id',
                'organizations.name_of_the_office_head',
                'organizations.name_of_the_office_head_en',
                'organizations.name_of_the_office_head_designation',
                'organizations.name_of_the_office_head_designation_en',
                'organizations.domain',
                'organizations.fax_no',
                'organizations.mobile',
                'organizations.email',
                'organizations.contact_person_name',
                'organizations.contact_person_name_en',
                'organizations.contact_person_mobile',
                'organizations.contact_person_email',
                'organizations.contact_person_designation',
                'organizations.contact_person_designation_en',
                'organizations.description',
                'organizations.description_en',
                'organizations.logo',
                'organizations.loc_division_id',
                'organizations.loc_district_id',
                'organizations.loc_upazila_id',
                'organizations.address',
                'organizations.address_en',
                'industry_association_organization.row_status',
                'organizations.created_at',
                'organizations.updated_at'
            ]
        );


        $organizationBuilder->join('industry_association_organization', function ($join) use ($industryAssociationId) {
            $join->on('industry_association_organization.organization_id', '=', 'organizations.id')
                ->where('industry_association_organization.industry_association_id', $industryAssociationId);
        });


        if (!empty($titleEn)) {
            $organizationBuilder->where('organizations.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($title)) {
            $organizationBuilder->where('organizations.title', 'like', '%' . $title . '%');
        }
        if (!empty($searchText)) {
            $organizationBuilder->where(function ($builder) use ($searchText) {
                $builder->orwhere('organizations.title', 'like', '%' . $searchText . '%');
                $builder->orwhere('organizations.title_en', 'like', '%' . $searchText . '%');
            });
        }
        if (!empty($membershipId)) {
            $organizationBuilder->where('industry_association_organization.membership_id', $membershipId);
        }
        if (is_numeric($rowStatus)) {
            $organizationBuilder->where('industry_association_organization.row_status', $rowStatus);
        }
        /** @var Collection $organizations */

        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $organizations = $organizationBuilder->paginate($pageSize);
            $paginateData = (object)$organizations->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $organizations = $organizationBuilder->get();
        }


        $response['order'] = $order;
        $response['data'] = $organizations->toArray()['data'] ?? $organizations->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];

        return $response;
    }


    /**
     * @param array $request
     * @param Carbon $startTime
     * @return array
     */
    public function getPublicOrganizationListByIndustryAssociation(array $request, Carbon $startTime): array
    {
        $titleEn = $request['title_en'] ?? "";
        $title = $request['title'] ?? "";
        $searchText = $request['search_text'] ?? "";
        $paginate = $request['page'] ?? "";
        $pageSize = $request['page_size'] ?? "";
        $order = $request['order'] ?? "ASC";
        $industryAssociationId = $request['industry_association_id'];
        $membershipId = $request['membership_id'] ?? "";


        $organizationBuilder = Organization::select(
            [
                'organizations.id',
                'organizations.title_en',
                'organizations.title',
                'organizations.date_of_establishment',
                'industry_association_organization.membership_id',
                'organizations.id',
                'organizations.name_of_the_office_head',
                'organizations.name_of_the_office_head_en',
                'organizations.name_of_the_office_head_designation',
                'organizations.name_of_the_office_head_designation_en',
                'organizations.domain',
                'organizations.fax_no',
                'organizations.mobile',
                'organizations.mobile_numbers',
                'organizations.phone_numbers',
                'organizations.email',
                'organizations.contact_person_name',
                'organizations.contact_person_name_en',
                'organizations.contact_person_mobile',
                'organizations.contact_person_email',
                'organizations.contact_person_designation',
                'organizations.contact_person_designation_en',
                'organizations.description',
                'organizations.description_en',
                'organizations.logo',
                'organizations.loc_division_id',
                'organizations.loc_district_id',
                'organizations.loc_upazila_id',
                'organizations.address',
                'organizations.address_en',
                'organizations.row_status',
                'organizations.created_at',
                'organizations.updated_at'
            ]
        );

        if (is_numeric($industryAssociationId)) {
            $organizationBuilder->join('industry_association_organization', function ($join) use ($industryAssociationId) {
                $join->on('industry_association_organization.organization_id', '=', 'organizations.id')
                    ->where('industry_association_organization.industry_association_id', $industryAssociationId)
                    /** Only payment status is applicable for Nascib otherwise fetch active row status*/
                    ->where(function ($subQuery) {
                        $subQuery->orWhere("industry_association_organization.payment_status", BaseModel::PAYMENT_NOT_APPLICABLE)
                            ->where('industry_association_organization.row_status', BaseModel::ROW_STATUS_ACTIVE)
                            ->orWhere(function ($subQueryNested) {
                                $subQueryNested->where('industry_association_organization.row_status', BaseModel::ROW_STATUS_ACTIVE)
                                    ->where('industry_association_organization.payment_status', BaseModel::PAYMENT_SUCCESS);
                            });
                    });
            });
        }

        if (!empty($titleEn)) {
            $organizationBuilder->where('organizations.title_en', 'like', '%' . $titleEn . '%');
        }
        if (!empty($title)) {
            $organizationBuilder->where('organizations.title', 'like', '%' . $title . '%');
        }
        if (!empty($searchText)) {
            $organizationBuilder->where(function ($builder) use ($searchText) {
                $builder->orwhere('organizations.title', 'like', '%' . $searchText . '%');
                $builder->orwhere('organizations.title_en', 'like', '%' . $searchText . '%');
            });
        }
        if (!empty($membershipId)) {
            $organizationBuilder->where('industry_association_organization.membership_id', $membershipId);
        }


        /** @var Collection $organizations */
        if (is_numeric($paginate) || is_numeric($pageSize)) {
            $pageSize = $pageSize ?: BaseModel::DEFAULT_PAGE_SIZE;
            $organizations = $organizationBuilder->paginate($pageSize);
            $paginateData = (object)$organizations->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $organizations = $organizationBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $organizations->toArray()['data'] ?? $organizations->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];

        return $response;
    }

    /**
     * @param int $id
     * @return Organization
     */
    public function getOneOrganization(int $id): Organization
    {
        /** @var Organization|Builder $organizationBuilder */
        $organizationBuilder = Organization::select([
            'organizations.id',
            'organizations.title_en',
            'organizations.title',
            'organizations.date_of_establishment',
            'organizations.name_of_the_office_head',
            'organizations.name_of_the_office_head_en',
            'organizations.name_of_the_office_head_designation',
            'organizations.name_of_the_office_head_designation_en',
            'organizations.domain',
            'organizations.fax_no',
            'organizations.mobile',
            'organizations.mobile_numbers',
            'organizations.phone_numbers',
            'organizations.email',
            'organizations.contact_person_name',
            'organizations.contact_person_name_en',
            'organizations.contact_person_mobile',
            'organizations.contact_person_email',
            'organizations.contact_person_designation',
            'organizations.contact_person_designation_en',
            'organizations.description',
            'organizations.description_en',
            'organizations.logo',
            'organizations.loc_division_id',
            'loc_divisions.title_en as loc_division_title_en',
            'loc_divisions.title as loc_division_title',
            'organizations.loc_district_id',
            'loc_districts.title_en as loc_district_title_en',
            'loc_districts.title as loc_district_title',
            'organizations.loc_upazila_id',
            'loc_upazilas.title_en as loc_upazila_title_en',
            'loc_upazilas.title as loc_upazila_title',
            'organizations.location_latitude',
            'organizations.location_longitude',
            'organizations.google_map_src',
            'organizations.organization_type_id',
            'organization_types.title_en as organization_type_title_en',
            'organization_types.title as organization_type_title',
            'organizations.address',
            'organizations.address_en',
            'organizations.row_status',
            'organizations.created_by',
            'organizations.updated_by',
            'organizations.created_at',
            'organizations.updated_at'
        ]);
        $organizationBuilder->join('organization_types', function ($join) {
            $join->on('organizations.organization_type_id', '=', 'organization_types.id')
                ->whereNull('organization_types.deleted_at');
        });
        $organizationBuilder->leftjoin('loc_divisions', function ($join) {
            $join->on('organizations.loc_division_id', '=', 'loc_divisions.id')
                ->whereNull('loc_divisions.deleted_at');

        });
        $organizationBuilder->leftjoin('loc_districts', function ($join) {
            $join->on('organizations.loc_district_id', '=', 'loc_districts.id')
                ->whereNull('loc_districts.deleted_at');
        });
        $organizationBuilder->leftjoin('loc_upazilas', function ($join) {
            $join->on('organizations.loc_upazila_id', '=', 'loc_upazilas.id')
                ->whereNull('loc_upazilas.deleted_at');

        });

        $organizationBuilder->where('organizations.id', '=', $id);


        $organizationBuilder->with(['subTrades.trade', 'industryAssociations']);

        return $organizationBuilder->firstOrFail();
    }

    public function getAdditionalModelData(array &$organization)
    {
        if (!empty($organization['industry_associations'][0]['pivot']['additional_info_model_name']) && $organization['industry_associations'][0]['pivot']['additional_info_model_name'] == NascibMember::class) {

            if ($organization['industry_associations'][0]['pivot']['payment_status'] == PaymentTransactionHistory::PAYMENT_PENDING) {

                $industryAssociationOrganizationId = $organization['industry_associations'][0]['pivot']['id'];
                $industryAssociationId = $organization['industry_associations'][0]['pivot']['industry_association_id'];
                $applicationType = NascibMember::APPLICATION_TYPE_NEW;

                /**
                 * If you get Payment Page Url For NascibPayment, you have to send following parameters
                 * $industryAssociationId,
                 * $industryAssociationOrganizationId
                 * $applicationType
                 */

                $organization['additional_information']['payment_page_url'] = app(NascibMemberService::class)->getPaymentPageUrlForNascibPayment($industryAssociationId, $industryAssociationOrganizationId, $applicationType);
            }

            $nascibMember = NascibMember::where('industry_association_organization_id', $organization['industry_associations'][0]['pivot']['id'])->first();
            if (!empty($nascibMember)) {
                $organization['additional_information']['additional_info_model_data'] = $nascibMember->toArray();
            } else {
                $organization['additional_information']['additional_info_model_data'] = [];
            }

        } else if (!empty($organization['industry_associations'][0]['pivot']['additional_info_model_name']) && $organization['industry_associations'][0]['pivot']['additional_info_model_name'] == SmefMember::class) {
            $smefMember = SmefMember::where('industry_association_organization_id', $organization['industry_associations'][0]['pivot']['id'])->first();
            if (!empty($smefMember)) {
                $organization['additional_information']['additional_info_model_data'] = $smefMember->toArray();
            } else {
                $organization['additional_information']['additional_info_model_data'] = [];
            }

        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getOrganizationTitle(Request $request): array
    {
        return Organization::select([
            "id",
            "title",
            "title_en"
        ])->whereIn("id", $request->get('organization_ids'))
            ->get()->keyBy("id")->toArray();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getIndustryAssociationTitle(Request $request): array
    {
        return IndustryAssociation::select([
            "id",
            "title",
            "title_en"
        ])->whereIn("id", $request->get('industry_association_ids'))
            ->get()->keyBy("id")->toArray();
    }

    /**
     * @param Organization $organization
     * @param array $data
     * @param bool $isOpenReg
     * @return Organization
     */
    public function store(Organization $organization, array $data, bool $isOpenReg = false): Organization
    {
        $organization->fill($data);
        $organization->save();
        $this->addOrganizationToIndustryAssociation($organization, $data, $isOpenReg);
        return $organization;
    }

    public function addOrganizationToIndustryAssociation(Organization $organization, array $data, bool $isOpenReg = false)
    {

        foreach ($data['industry_associations'] as $row) {
            $organization->industryAssociations()->attach($row['industry_association_id'], [
                'membership_id' => $row['membership_id'],
                'row_status' => $isOpenReg ? BaseModel::ROW_STATUS_PENDING : BaseModel::ROW_STATUS_ACTIVE
            ]);
        }
    }

    /**
     * Add organization to a industryAssociation
     * @param Organization $organization
     * @param array $subTrades
     */
    public function syncWithSubTrades(Organization $organization, array $subTrades)
    {
        $organization->subTrades()->sync($subTrades);
    }

    /**
     *industryAssociation membership application from industry
     * @param array $data
     */
    public function IndustryAssociationMembershipApplication(array $data)
    {
        $organization = Organization::findOrFail($data['organization_id']);
        $dataUpdate = $organization->industryAssociations()->updateExistingPivot($data['industry_association_id'], [
            'row_status' => BaseModel::ROW_STATUS_PENDING
        ]);
        if (!$dataUpdate) {
            $organization->industryAssociations()->attach($data['industry_association_id'], [
                'membership_id' => $data['membership_id'],
                'row_status' => BaseModel::ROW_STATUS_PENDING
            ]);
        }

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function IndustryAssociationMembershipValidation(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'membership_id' => [
                'required',
                'string',
            ],
            'industry_association_id' => [
                'required',
                'integer',
                'exists:industry_associations,id,deleted_at,NULL'
            ],
            'organization_id' => [
                'required',
                'integer',
                'exists:organizations,id,deleted_at,NULL',
                Rule::unique('industry_association_organization', 'organization_id')
                    ->where(function (\Illuminate\Database\Query\Builder $query) use ($request) {
                        return $query->where('industry_association_id', '=', $request->input('industry_association_id'))
                            ->whereIn('row_status', [BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_PENDING]);
                    })
            ],

        ];

        return Validator::make($request->all(), $rules);

    }

    /**
     * @param array $data
     * @return mixed
     * @throws RequestException
     */
    public function createUser(array $data): mixed
    {
        $url = clientUrl(BaseModel::CORE_CLIENT_URL_TYPE) . 'admin-user-create';
        $userPostField = [
            'permission_sub_group_id' => $data['permission_sub_group_id'] ?? "",
            'user_type' => BaseModel::ORGANIZATION_USER_TYPE,
            'organization_id' => $data['organization_id'] ?? "",
            'username' => $data['contact_person_mobile'] ?? "",
            'name_en' => $data['contact_person_name'] ?? "",
            'name' => $data['contact_person_name'] ?? "",
            'email' => $data['contact_person_email'] ?? "",
            'mobile' => $data['contact_person_mobile'] ?? ""
        ];

        Log::channel("org_reg")->info("Admin reg organization payload sent to core below");
        Log::channel("org_reg")->info(json_encode($userPostField));

        return Http::withOptions(
            [
                'verify' => config('nise3.should_ssl_verify'),
                'debug' => config('nise3.http_debug')
            ])
            ->timeout(120)
            ->post($url, $userPostField)
            ->throw(static function (\Illuminate\Http\Client\Response $httpResponse, $httpException) use ($url) {
                Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . $httpResponse->body());
                throw new HttpErrorException($httpResponse);
            })
            ->json();
    }


    /**
     * @param array $data
     * @return mixed
     * @throws RequestException
     */
    public function createOpenRegisterUser(array $data): mixed
    {
        $url = clientUrl(BaseModel::CORE_CLIENT_URL_TYPE) . 'user-open-registration';

        Log::channel('org_reg')->info("organization registration core hit point");

        Log::channel('org_reg')->info($url);

        $userPostField = [
            'user_type' => BaseModel::ORGANIZATION_USER_TYPE,
            'username' => $data['contact_person_mobile'] ?? "",
            'organization_id' => $data['organization_id'] ?? "",
            'name_en' => $data['contact_person_name_en'] ?? "",
            'name' => $data['contact_person_name'] ?? "",
            'email' => $data['contact_person_email'] ?? "",
            'mobile' => $data['contact_person_mobile'] ?? "",
            'password' => $data['password'] ?? ""
        ];

        Log::channel('org_reg')->info("organization registration data provided to core", $userPostField);

        return Http::withOptions(
            [
                'verify' => config('nise3.should_ssl_verify'),
                'debug' => config('nise3.http_debug')
            ])
            ->timeout(120)
            ->post($url, $userPostField)
            ->throw(static function (\Illuminate\Http\Client\Response $httpResponse, $httpException) use ($url, $userPostField) {
                Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . $httpResponse->body());
                throw new HttpErrorException($httpResponse);
            })
            ->json();
    }

    /**
     * @param Organization $organization
     * @param array $data
     * @return Organization
     */
    public function update(Organization $organization, array $data): Organization
    {
        $organization->fill($data);
        $this->updateIndustryAssociationMembership($organization, $data);
        $organization->save();
        return $organization;
    }

    /**
     * @param Organization $organization
     * @param array $data
     * @return Organization
     */
    public function organizationProfileUpdate(Organization $organization, array $data): Organization
    {
        $organization->fill($data);
        $organization->save();
        return $organization;
    }

    /**
     * @param Organization $organization
     * @param array $data
     */
    public function updateIndustryAssociationMembership(Organization $organization, array $data)
    {
        foreach ($data['industry_associations'] as $row) {
            $organization->industryAssociations()->updateExistingPivot($row['industry_association_id'], [
                'membership_id' => $row['membership_id'],
            ]);
        }
    }

    /**
     * @param Organization $organization
     * @return bool
     */
    public function destroy(Organization $organization): bool
    {
        return $organization->delete();
    }

    /**
     * @param Organization $organization
     * @return bool
     * @throws RequestException
     */
    public function userDestroy(Organization $organization)
    {
        $url = clientUrl(BaseModel::CORE_CLIENT_URL_TYPE) . 'user-delete';
        $userPostField = [
            'user_type' => BaseModel::ORGANIZATION_USER_TYPE,
            'organization_id' => $organization->id,
        ];

        return Http::withOptions(
            [
                'verify' => config('nise3.should_ssl_verify'),
                'debug' => config('nise3.http_debug')
            ])
            ->timeout(120)
            ->delete($url, $userPostField)
            ->throw(static function (\Illuminate\Http\Client\Response $httpResponse, $httpException) use ($url) {
                Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . $httpResponse->body());
                throw new HttpErrorException($httpResponse);
            })
            ->json();
    }


    /**
     * @param Request $request
     * @param Carbon $startTime
     * @return array
     */
    public function getAllTrashedOrganization(Request $request, Carbon $startTime): array
    {
        $titleEn = $request->query('title_en');
        $title = $request->query('title');
        $page_size = $request->query('page_size', BaseModel::DEFAULT_PAGE_SIZE);
        $paginate = $request->query('page');
        $order = !empty($request->query('order')) ? $request->query('order') : 'ASC';

        /** @var Builder organizationBuilder */
        $organizationBuilder = Organization::onlyTrashed()->select([
            'organizations.id',
            'organizations.title_en',
            'organizations.title',
            'organizations.domain',
            'organizations.fax_no',
            'organizations.mobile',
            'organizations.email',
            'organizations.contact_person_name',
            'organizations.contact_person_mobile',
            'organizations.contact_person_email',
            'organizations.contact_person_designation',
            'organizations.description',
            'organizations.logo',
            'organizations.loc_division_id',
            'organizations.loc_district_id',
            'organizations.loc_upazila_id',
            'organizations.organization_type_id',
            'organization_types.title_en as organization_types_title',
            'organizations.address',
            'organizations.row_status',
            'organizations.created_by',
            'organizations.updated_by',
            'organizations.created_at',
            'organizations.updated_at'
        ]);
        $organizationBuilder->join('organization_types', 'organizations.organization_type_id', '=', 'organization_types.id');
        $organizationBuilder->orderBy('organizations.id', $order);

        if (!empty($titleEn)) {
            $organizationBuilder->where('organization_types.title_en', 'like', '%' . $titleEn . '%');
        } elseif (!empty($title)) {
            $organizationBuilder->where('organization_types.title', 'like', '%' . $title . '%');
        }

        /** @var Collection $organizations */

        if (is_numeric($paginate) || is_numeric($page_size)) {
            $page_size = $page_size ?: BaseModel::DEFAULT_PAGE_SIZE;
            $organizations = $organizationBuilder->paginate($page_size);
            $paginateData = (object)$organizations->toArray();
            $response['current_page'] = $paginateData->current_page;
            $response['total_page'] = $paginateData->last_page;
            $response['page_size'] = $paginateData->per_page;
            $response['total'] = $paginateData->total;
        } else {
            $organizations = $organizationBuilder->get();
        }

        $response['order'] = $order;
        $response['data'] = $organizations->toArray()['data'] ?? $organizations->toArray();
        $response['_response_status'] = [
            "success" => true,
            "code" => Response::HTTP_OK,
            "query_time" => $startTime->diffInSeconds(Carbon::now())
        ];

        return $response;
    }

    /**
     * @param Organization $organization
     * @return bool
     */
    public function restore(Organization $organization): bool
    {
        return $organization->restore();
    }

    /**
     * @param Organization $organization
     * @return bool
     */
    public function forceDelete(Organization $organization): bool
    {
        return $organization->forceDelete();
    }

    /**
     * @param Organization $organization
     * @return Organization
     */
    public function organizationStatusChangeAfterApproval(Organization $organization): Organization
    {
        $organization->row_status = BaseModel::ROW_STATUS_ACTIVE;
        $organization->save();
        return $organization;
    }

    /**
     * @param Organization $organization
     * @return Organization
     */
    public function organizationStatusChangeAfterRejection(Organization $organization): Organization
    {
        $organization->row_status = BaseModel::ROW_STATUS_REJECTED;
        $organization->save();
        return $organization;
    }

    /**
     * @param Organization $organization
     */
    public function industryAssociationMembershipApproval(Organization $organization)
    {
        $industryAssociationId = request('industry_association_id');

        $organization->industryAssociations()->updateExistingPivot($industryAssociationId, [
            'row_status' => BaseModel::ROW_STATUS_ACTIVE
        ]);

    }


    /**
     * @param Organization $organization
     */
    public function industryAssociationMembershipRejection(Organization $organization)
    {
        $industryAssociationId = request('industry_association_id');

        $organization->industryAssociations()->updateExistingPivot($industryAssociationId, [
            'row_status' => BaseModel::ROW_STATUS_REJECTED
        ]);
    }

    /**
     * @param Request $request
     * @param Organization $organization
     * @return mixed
     * @throws RequestException
     */
    public function organizationUserApproval(Request $request, Organization $organization): mixed
    {
        $url = clientUrl(BaseModel::CORE_CLIENT_URL_TYPE) . 'user-approval';
        $userPostField = [
            'user_type' => BaseModel::ORGANIZATION_USER_TYPE,
            'organization_id' => $organization->id,
            'permission_sub_group_id' => $request->input('permission_sub_group_id') ?? "",
            'name_en' => $organization->contact_person_name ?? "",
            'name' => $organization->contact_person_name ?? "",
            'row_status' => $organization->row_status
        ];

        return Http::withOptions(
            [
                'verify' => config('nise3.should_ssl_verify'),
                'debug' => config('nise3.http_debug')
            ])
            ->timeout(120)
            ->put($url, $userPostField)
            ->throw(static function (\Illuminate\Http\Client\Response $httpResponse, $httpException) use ($url) {
                Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . $httpResponse->body());
                throw new HttpErrorException($httpResponse);
            })
            ->json();

    }

    /**
     * @throws RequestException
     */
    public function organizationUserRejection(Organization $organization)
    {
        $url = clientUrl(BaseModel::CORE_CLIENT_URL_TYPE) . 'user-rejection';
        $userPostField = [
            'user_type' => BaseModel::ORGANIZATION_USER_TYPE,
            'organization_id' => $organization->id,
        ];

        return Http::withOptions(
            [
                'verify' => config('nise3.should_ssl_verify'),
                'debug' => config('nise3.http_debug')
            ])
            ->timeout(120)
            ->put($url, $userPostField)
            ->throw(static function (\Illuminate\Http\Client\Response $httpResponse, $httpException) use ($url) {
                Log::debug(get_class($httpResponse) . ' - ' . get_class($httpException));
                Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . $httpResponse->body());
                throw new HttpErrorException($httpResponse);
            })
            ->json();

    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $data = $request->all();
        if (!empty($data['phone_numbers'])) {
            $data["phone_numbers"] = isset($data['phone_numbers']) && is_array($data['phone_numbers']) ? $data['phone_numbers'] : explode(',', $data['phone_numbers']);
        }
        if (!empty($data['mobile_numbers'])) {
            $data["mobile_numbers"] = isset($data['mobile_numbers']) && is_array($data['mobile_numbers']) ? $data['mobile_numbers'] : explode(',', $data['mobile_numbers']);
        }
        if (!empty($data["sub_trades"])) {
            $data["sub_trades"] = is_array($data['sub_trades']) ? $data['sub_trades'] : explode(',', $data['sub_trades']);
        }
        $customMessage = [
            'row_status.in' => 'Row status must be within 1 or 0. [30000]',
        ];
        $rules = [
            'organization_type_id' => [
                'required',
                'int',
                'exists:organization_types,id,deleted_at,NULL'
            ],
            'sub_trades' => [
                'required',
                'array',
                'min:1'
            ],
            'sub_trades.*' => [
                'nullable',
                'integer',
                'exists:sub_trades,id,deleted_at,NULL'
            ],
            'industry_associations' => [
                'required',
                'array',
                'min:1',
            ],
            'industry_associations.*' => [
                'array',
                'required',
            ],
            'industry_associations.*.industry_association_id' => [
                'required',
                'int',
                'distinct',
            ],
            'mobile_numbers' => [
                'nullable',
                'array'
            ],
            'mobile_numbers.*' => [
                'nullable',
                'string',
                BaseModel::MOBILE_REGEX
            ],
            'phone_numbers' => [
                'nullable',
                'array'
            ],
            'phone_numbers.*' => [
                'nullable',
                'string',
            ],
            'industry_associations.*.membership_id' => [
                'string',
                'required',
            ],
            'permission_sub_group_id' => [
                Rule::requiredIf(function () use ($id) {
                    return is_null($id);
                }),
                'nullable',
                'integer'
            ],
            'date_of_establishment' => [
                'nullable',
                'date_format:Y-m-d'
            ],
            'title_en' => [
                'nullable',
                'string',
                'max:600',
                'min:2',
            ],
            'title' => [
                'required',
                'string',
                'max:1200',
                'min:2'
            ],
            'loc_division_id' => [
                'required',
                'integer',
                'exists:loc_divisions,id,deleted_at,NULL'
            ],
            'loc_district_id' => [
                'required',
                'integer',
                'exists:loc_districts,id,deleted_at,NULL'
            ],
            'loc_upazila_id' => [
                'nullable',
                'integer',
                'exists:loc_upazilas,id,deleted_at,NULL'
            ],
            "location_latitude" => [
                'nullable',
                'string',
            ],
            "location_longitude" => [
                'nullable',
                'string',
            ],
            "google_map_src" => [
                'nullable',
                'string',
            ],
            'address' => [
                'required',
                'max: 1200',
                'min:2'
            ],
            'address_en' => [
                'nullable',
                'max: 600',
                'min:2'
            ],
            "country" => [
                "nullable",
                "string",
                "min:2"
            ],
            "phone_code" => [
                "nullable",
                "string"
            ],
            'mobile' => [
                'required',
                BaseModel::MOBILE_REGEX,
            ],
            'email' => [
                'required',
                'email',
                'max:320'
            ],
            'fax_no' => [
                'nullable',
                'string',
                'max: 30',
            ],
            "name_of_the_office_head" => [
                "nullable",
                "string",
                'max:600'
            ],
            "name_of_the_office_head_en" => [
                "nullable",
                "string",
                'max:600'
            ],
            "name_of_the_office_head_designation" => [
                "nullable",
                "string"
            ],
            "name_of_the_office_head_designation_en" => [
                "nullable",
                "string"
            ],
            'contact_person_name' => [
                'required',
                'max: 500',
                'min:2'
            ],
            'contact_person_name_en' => [
                'nullable',
                'max: 250',
                'min:2'
            ],
            'contact_person_mobile' => [
                'required',
                Rule::unique('organizations', 'contact_person_mobile')
                    ->ignore($id)
                    ->where(function (\Illuminate\Database\Query\Builder $query) {
                        return $query->whereNull('deleted_at');
                    }),
                BaseModel::MOBILE_REGEX,
            ],
            'contact_person_email' => [
                'required',
                'email',
                Rule::unique('organizations', 'contact_person_email')
                    ->ignore($id)
                    ->where(function (\Illuminate\Database\Query\Builder $query) {
                        return $query->whereNull('deleted_at');
                    })
            ],
            'contact_person_designation' => [
                'required',
                'max: 600',
                "min:2"
            ],
            'contact_person_designation_en' => [
                'nullable',
                'max: 300',
                "min:2"
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'description_en' => [
                'nullable',
                'string',
            ],
            'domain' => [
                'nullable',
                'regex:/^(http|https):\/\/[a-zA-Z-\-\.0-9]+$/',
                'string',
                'max:191',
                Rule::unique('organizations', 'domain')
                    ->ignore($id)
                    ->where(function (\Illuminate\Database\Query\Builder $query) {
                        return $query->whereNull('deleted_at');
                    })
            ],
            'logo' => [
                'nullable',
                'string',
            ],
            'row_status' => [
                'nullable',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ],
        ];
        return Validator::make($data, $rules, $customMessage);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function excelImportValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $data = $request->all();
        $rules = [
            'file' => 'required|mimes:xlsx, csv, xls'
        ];
        return Validator::make($data, $rules);
    }

    /**
     * @param array $excelData
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function excelDataValidator(array $excelData): \Illuminate\Contracts\Validation\Validator
    {
        /** $excelData owns an array. So use * as prefix */
        $rules = [
            '*.industry_associations' => [
                'required',
                'array',
                'min:1',
            ],
            '*.industry_associations.*' => [
                'array',
                'required',
            ],
            '*.industry_associations.*.industry_association_id' => [
                'required',
                'int',
            ],
            '*.industry_associations.*.membership_id' => [
                'string',
                'required',
            ],
            '*.organization_type_id' => [
                'required',
                'int',
                'exists:organization_types,id,deleted_at,NULL'
            ],
            '*.sub_trades' => [
                'required',
                'array',
                'min:1'
            ],
            '*.sub_trades.*' => [
                'nullable',
                'integer',
                'exists:sub_trades,id,deleted_at,NULL'
            ],
            '*.permission_sub_group_id' => [
                'required',
                'integer'
            ],
            '*.date_of_establishment' => [
                'nullable',
                'date_format:Y-m-d'
            ],
            '*.title_en' => [
                'nullable',
                'string',
                'max:600',
                'min:2',
            ],
            '*.title' => [
                'required',
                'string',
                'max:1200',
                'min:2'
            ],
            '*.loc_division_id' => [
                'required',
                'integer',
                'exists:loc_divisions,id,deleted_at,NULL'
            ],
            '*.loc_district_id' => [
                'required',
                'integer',
                'exists:loc_districts,id,deleted_at,NULL'
            ],
            '*.loc_upazila_id' => [
                'nullable',
                'integer',
                'exists:loc_upazilas,id,deleted_at,NULL'
            ],
            "*.location_latitude" => [
                'nullable',
                'string',
            ],
            "*.location_longitude" => [
                'nullable',
                'string',
            ],
            "*.google_map_src" => [
                'nullable',
                'string',
            ],
            '*.address' => [
                'required',
                'max: 1200',
                'min:2'
            ],
            '*.address_en' => [
                'nullable',
                'max: 600',
                'min:2'
            ],
            "*.country" => [
                "nullable",
                "string",
                "min:2"
            ],
            "*.phone_code" => [
                "nullable",
                "string"
            ],
            '*.mobile' => [
                'required',
                BaseModel::MOBILE_REGEX,
            ],
            '*.email' => [
                'required',
                'email',
                'max:320'
            ],
            '*.fax_no' => [
                'nullable',
                'string',
                'max: 30',
            ],
            "*.name_of_the_office_head" => [
                "nullable",
                "string",
                'max:600'
            ],
            "*.name_of_the_office_head_en" => [
                "nullable",
                "string",
                'max:600'
            ],
            "*.name_of_the_office_head_designation" => [
                "nullable",
                "string"
            ],
            "*.name_of_the_office_head_designation_en" => [
                "nullable",
                "string"
            ],
            '*.contact_person_name' => [
                'required',
                'max: 500',
                'min:2'
            ],
            '*.contact_person_name_en' => [
                'nullable',
                'max: 250',
                'min:2'
            ],
            '*.contact_person_mobile' => [
                'required',
                /*Rule::unique('organizations', 'contact_person_mobile')
                    ->where(function (\Illuminate\Database\Query\Builder $query) {
                        return $query->whereNull('deleted_at');
                    }),*/
                BaseModel::MOBILE_REGEX,
            ],
            '*.contact_person_email' => [
                'required',
                'email',
                /*Rule::unique('organizations', 'contact_person_email')
                    ->where(function (\Illuminate\Database\Query\Builder $query) {
                        return $query->whereNull('deleted_at');
                    })*/
            ],
            '*.contact_person_designation' => [
                'required',
                'max: 600',
                "min:2"
            ],
            '*.contact_person_designation_en' => [
                'nullable',
                'max: 300',
                "min:2"
            ],
            '*.description' => [
                'nullable',
                'string',
            ],
            '*.description_en' => [
                'nullable',
                'string',
            ],
            '*.logo' => [
                'nullable',
                'string',
            ],
            '*.row_status' => [
                'nullable',
                Rule::in([BaseModel::ROW_STATUS_ACTIVE, BaseModel::ROW_STATUS_INACTIVE]),
            ]
        ];
        return Validator::make($excelData, $rules);
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function registerOrganizationValidator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'title_en' => [
                'nullable',
                'string',
                'max:600',
                'min:2',
            ],
            'title' => [
                'required',
                'string',
                'max:1200',
                'min:2'
            ],
            'date_of_establishment' => [
                'nullable',
                'date_format:Y-m-d'
            ],
            'organization_type_id' => [
                'required',
                'integer',
                'exists:organization_types,id,deleted_at,NULL'
            ],
            'industry_associations' => [
                'required',
                'array',
                'min:1',
            ],
            'industry_associations.*' => [
                'array',
                'required',
            ],
            'industry_associations.*.industry_association_id' => [
                'required',
                'int',
                'distinct',
            ],
            'industry_associations.*.membership_id' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                'email',
            ],
            'mobile' => [
                'required',
                BaseModel::MOBILE_REGEX,
            ],
            'contact_person_mobile' => [
                'required',
                Rule::unique('organizations', 'contact_person_mobile')
                    ->ignore($id)
                    ->where(function (\Illuminate\Database\Query\Builder $query) {
                        return $query->whereNull('deleted_at');
                    }),
                BaseModel::MOBILE_REGEX,

            ],
            "name_of_the_office_head" => [
                "required",
                "string",
                'max:600',
                'min:2'
            ],
            "name_of_the_office_head_en" => [
                "nullable",
                "string",
                'max:300',
                'min:2'
            ],
            "name_of_the_office_head_designation" => [
                "nullable",
                "string",
                'max:600',
                'min:2'
            ],
            "name_of_the_office_head_designation_en" => [
                "nullable",
                "string",
                'max:300',
                'min:2'
            ],
            'contact_person_name' => [
                'required',
                'max: 500',
                'min:2'
            ],
            'contact_person_name_en' => [
                'nullable',
                'max: 250',
                'min:2'
            ],
            'contact_person_designation' => [
                'required',
                'max: 600',
                "min:2"
            ],
            'contact_person_designation_en' => [
                'nullable',
                'max: 300',
                "min:2"
            ],
            'contact_person_email' => [
                'required',
                'email',
                Rule::unique('organizations', 'contact_person_email')
                    ->ignore($id)
                    ->where(function (\Illuminate\Database\Query\Builder $query) {
                        return $query->whereNull('deleted_at');
                    })
            ],
            'loc_division_id' => [
                'required',
                'integer',
                'exists:loc_divisions,id,deleted_at,NULL'
            ],
            'loc_district_id' => [
                'required',
                'integer',
                'exists:loc_districts,id,deleted_at,NULL'
            ],
            'loc_upazila_id' => [
                'nullable',
                'integer',
                'exists:loc_upazilas,id,deleted_at,NULL'
            ],
            'address' => [
                'required',
                'max: 1200',
                'min:2'
            ],
            'address_en' => [
                'nullable',
                'max: 600',
                'min:2'
            ],
            "password" => [
                "required",
                "confirmed",
                Password::min(BaseModel::PASSWORD_MIN_LENGTH)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
            "password_confirmation" => 'required_with:password',
            'row_status' => [
                'nullable',
                Rule::in([BaseModel::ROW_STATUS_PENDING])
            ]
        ];

        return Validator::make($request->all(), $rules);
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
            'title_en' => 'nullable|max:600|min:2',
            'title' => 'nullable|max:1200|min:2',
            'membership_id' => 'nullable',
            'page' => 'integer|gt:0',
            'page_size' => 'integer|gt:0',
            'organization_type_id' => 'nullable|integer|gt:0',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "nullable",
                "integer",
                Rule::in(Organization::ROW_STATUSES),
            ],
        ], $customMessage);
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function organizationProfileUpdateValidator(Request $request, int $id = null): \Illuminate\Contracts\Validation\Validator
    {
        $data = $request->all();
        if (!empty($data['phone_numbers'])) {
            $data["phone_numbers"] = isset($data['phone_numbers']) && is_array($data['phone_numbers']) ? $data['phone_numbers'] : explode(',', $data['phone_numbers']);
        }
        if (!empty($data['mobile_numbers'])) {
            $data["mobile_numbers"] = isset($data['mobile_numbers']) && is_array($data['mobile_numbers']) ? $data['mobile_numbers'] : explode(',', $data['mobile_numbers']);
        }
        $customMessage = [
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
        ];

        $rules = [
            'title' => [
                'required',
                'string',
                'max:1000',
            ],
            'title_en' => [
                'nullable',
                'string',
                'max:500',
                'min:2'
            ],
            'loc_division_id' => [
                'required',
                'integer',
                'exists:loc_divisions,id,deleted_at,NULL'
            ],
            'loc_district_id' => [
                'required',
                'integer',
                'exists:loc_districts,id,deleted_at,NULL'
            ],
            'loc_upazila_id' => [
                'nullable',
                'integer',
                'exists:loc_upazilas,id,deleted_at,NULL'
            ],
            'location_latitude' => [
                'nullable',
                'string',
                'max:50'
            ],
            'location_longitude' => [
                'nullable',
                'string',
                'max:50'
            ],
            'mobile_numbers' => [
                'nullable',
                'array'
            ],
            'mobile_numbers.*' => [
                'nullable',
                'string',
                BaseModel::MOBILE_REGEX
            ],
            'phone_numbers' => [
                'nullable',
                'array'
            ],
            'phone_numbers.*' => [
                'nullable',
                'string',
            ],
            'google_map_src' => [
                'nullable',
                'string'
            ],
            'address' => [
                'nullable',
                'string'
            ],
            'address_en' => [
                'nullable',
                'string'
            ],
            'name_of_the_office_head' => [
                'required',
                'string',
                'max:500'
            ],
            'name_of_the_office_head_en' => [
                'nullable',
                'string'
            ],
            'name_of_the_office_head_designation' => [
                "required",
                "string",
                "max:500"
            ],
            'name_of_the_office_head_designation_en' => [
                "nullable",
                "string",
                "max:500"
            ],
            'contact_person_name' => [
                'required',
                'max: 500',
                'min:2'
            ],
            'contact_person_name_en' => [
                'nullable',
                'max: 250',
                'min:2'
            ],
            'contact_person_designation' => [
                'required',
                'max: 500',
                "min:2"
            ],
            'logo' => [
                'nullable',
                'string',
            ],
            'contact_person_designation_en' => [
                'nullable',
                'max: 300',
                "min:2"
            ],

            'created_by' => ['nullable', 'int'],
            'updated_by' => ['nullable', 'int'],
        ];
        return Validator::make($data, $rules, $customMessage);
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function IndustryAssociationMemberFilterValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'order.in' => 'Order must be within ASC or DESC.[30000]',
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
        ];

        if ($request->filled('order')) {
            $request->offsetSet('order', strtoupper($request->get('order')));
        }

        return Validator::make($request->all(), [
            'title_en' => 'nullable|max:600|min:2',
            'title' => 'nullable|max:1200|min:2',
            'search_text' => 'nullable|max:600|min:2',
            'page' => 'integer|gt:0',
            'membership_id' => 'nullable',
            'page_size' => 'integer|gt:0',
            'organization_type_id' => 'nullable|integer|gt:0',
            'industry_association_id' => 'required|integer|gt:0',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "nullable",
                "integer",
                Rule::in(Organization::ROW_STATUSES),
            ],
        ], $customMessage);
    }

    /**
     * @param Organization $organization
     * @return array
     */
    public function getOrganizationDashboardStatistics(Organization $organization): array
    {
        $employed = $this->employmentCountByOrganization($organization);
        $unemployed = 0;
        $vacancies = $this->getVacancyCountByOrganization($organization);
        $trendingSkills = $this->getTrendingJobSkillsCountByOrganization($organization);
        $hrDemandedVacancy = $this->getHrDemandedVacancy($organization);
        $hrDemandProvidedVacancy = $this->getHrDemandProvidedVacancyByInstitute($organization);

        return [
            "employed" => $employed,
            "unemployed" => $unemployed,
            "vacancies" => $vacancies,
            "trending_skills" => $trendingSkills,
            "hr_demanded" => $hrDemandedVacancy,
            "hr_demand_provided" => $hrDemandProvidedVacancy
        ];
    }

    /**
     * @param Organization $organization
     * @return int
     */
    public function employmentCountByOrganization(Organization $organization): int
    {
        return AppliedJob::query()
            ->join('primary_job_information', 'primary_job_information.job_id', '=', 'applied_jobs.job_id')
            ->where('primary_job_information.organization_id', $organization->id)
            ->where('applied_jobs.apply_status', AppliedJob::APPLY_STATUS["Hired"])
            ->count('applied_jobs.id');
    }

    /**
     * @param Organization $organization
     * @return int
     */
    public function getVacancyCountByOrganization(Organization $organization): int
    {
        return PrimaryJobInformation::where('organization_id', $organization->id)
            ->where('application_deadline', '>', Carbon::today())
            ->where('published_at', '<=', Carbon::now())
            ->sum('no_of_vacancies');
    }

    /**
     * @param Organization $organization
     * @return int
     */
    public function getTrendingJobSkillsCountByOrganization(Organization $organization): int
    {
        $candidateRequirementBuilder = CandidateRequirement::query()
            ->join('primary_job_information', 'primary_job_information.job_id', '=', 'candidate_requirements.job_id')
            ->where('primary_job_information.organization_id', $organization->id);

        $candidateRequirements = $candidateRequirementBuilder->get();

        $trendingSkills = 0;
        foreach ($candidateRequirements as $candidateRequirement) {
            $trendingSkills += $candidateRequirement->skills()->distinct()->count('skill_id');
        }
        return $trendingSkills;
    }

    /**
     * @param Organization $organization
     * @return int
     */
    public function getHrDemandedVacancy(Organization $organization): int
    {
        return HrDemand::where('organization_id', $organization->id)
            ->where('row_status', BaseModel::ROW_STATUS_ACTIVE)
            ->sum('vacancy');
    }

    /**
     * @param Organization $organization
     * @return int
     */
    public function getHrDemandProvidedVacancyByInstitute(Organization $organization): int
    {
        return HrDemand::where('organization_id', $organization->id)
            ->join('hr_demand_institutes', 'hr_demand_institutes.hr_demand_id', '=', 'hr_demands.id')
            ->where('hr_demand_institutes.row_status', BaseModel::ROW_STATUS_ACTIVE)
            ->where('hr_demands.row_status', BaseModel::ROW_STATUS_ACTIVE)
            ->sum('vacancy_provided_by_institute');
    }
}
