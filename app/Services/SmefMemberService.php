<?php

namespace App\Services;

use App\Exceptions\HttpErrorException;
use App\Facade\ServiceToServiceCall;
use App\Models\BaseModel;
use App\Models\IndustryAssociation;
use App\Models\IndustryAssociationConfig;
use App\Models\MembershipType;
use App\Models\SmefMember;
use App\Models\Organization;
use App\Models\PaymentTransactionHistory;
use App\Services\CommonServices\CodeGenerateService;
use App\Services\CommonServices\MailService;
use App\Services\CommonServices\SmsService;
use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Throwable;

/**
 *
 */
class SmefMemberService
{

    public function registerSmef(Organization $organization, SmefMember $smefMember, array $data): array
    {
        $orgData['organization_type_id'] = Organization::ORGANIZATION_TYPE_PRIVATE;
        $orgData['mobile'] = $data['entrepreneur_mobile'];
        $orgData['email'] = $data['entrepreneur_email'];
        $orgData['contact_person_name'] = $data['entrepreneur_name'];
        $orgData['contact_person_name_en'] = $data['entrepreneur_name_en'];
        $orgData['contact_person_mobile'] = $data['entrepreneur_mobile'];
        $orgData['contact_person_email'] = $data['entrepreneur_email'];
        $orgData['contact_person_designation'] = 'উদ্যোক্তা';
        $orgData['contact_person_designation_en'] = 'Entrepreneur';
        $orgData['membership_id'] = $data['code']."SMEF".time();

        /**Model Name For Smef Organization */
        $orgData['additional_info_model_name'] = SmefMember::class;
        $data = array_merge($data, $orgData);
        $organization->fill($data);
        $organization->save();

        $data['industry_association_organization_id'] = $this->attachToIndustryAssociation($organization, $data, true);

        $smefMember->fill($data);
        $smefMember->save();

        return [
            $organization,
            $smefMember
        ];
    }

    private function attachToIndustryAssociation(Organization $organization, array $data, bool $isOpenReg = false)
    {

        $organization->industryAssociations()->attach($data['industry_association_id'], [
            'membership_id' => $data['membership_id'],
            'additional_info_model_name' => $data['additional_info_model_name'],
            'row_status' => $isOpenReg ? BaseModel::ROW_STATUS_PENDING : BaseModel::ROW_STATUS_ACTIVE
        ]);
        $organization = $organization->fresh();
        return $organization->industryAssociations()->firstOrFail()->pivot->id;

    }

    /**
     * industryAssociation
     * @param array $data
     * @return mixed
     * @throws RequestException
     */
    public function createSmefUser(array $data): mixed
    {
        $smefUserPostField = [
            'organization_id' => $data['organization_id'],
            'contact_person_name' => $data['entrepreneur_name'],
            'contact_person_name_en' => $data['entrepreneur_name_en'],
            'contact_person_email' => $data['entrepreneur_email'],
            'contact_person_mobile' => $data['entrepreneur_mobile'],
            'password' => $data['password']
        ];

        Log::channel('idp_user')->info('Smef-User-Payload: ' . json_encode($smefUserPostField));
        return app(OrganizationService::class)->createOpenRegisterUser($smefUserPostField);

    }

    /**
     * @param IndustryAssociation $industryAssociation
     * @param array $data
     * @return IndustryAssociation
     */
    public function update(IndustryAssociation $industryAssociation, array $data): IndustryAssociation
    {
        $industryAssociation->fill($data);
        $industryAssociation->save();

        if (!empty($data['skills'])) {
            $this->syncSkill($industryAssociation, $data['skills']);
        } else {
            $this->syncSkill($industryAssociation, []);
        }

        return $industryAssociation;
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
            'form_fill_up_by' => [
                'required',
                'int',
                Rule::in(array_keys(SmefMember::FORM_FILL_UP_LIST))
            ],
            'application_tracking_no' => 'nullable|string|max: 191',
            'trade_license_no' => 'required|string|max:191|unique:smef_members,trade_license_no',
            /** Same as industry */
            'title' => 'required|string|max:500',
            'title_en' => 'nullable|string|max:191',
            'address' => 'required|string|max:1200',
            'address_en' => 'nullable|string|max:600',
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
            'domain' => 'nullable|string|max:255',
            /** end */
            'entrepreneur_name' => 'required|string|max: 100',
            'entrepreneur_name_en' => 'nullable|string|max: 100',
            'entrepreneur_gender' => 'required|int|digits_between: 1,2',
            'entrepreneur_date_of_birth' => 'required|date_format:Y-m-d',
            'entrepreneur_educational_qualification' => 'required|string|max: 191',
            'entrepreneur_nid' => 'required|string',
            'entrepreneur_nid_file_path' => [
                'required',
                'string'
            ],
            'entrepreneur_mobile' => [
                "required",
                BaseModel::MOBILE_REGEX
            ],
            'entrepreneur_email' => 'required|max:191|email',
            'entrepreneur_photo_path' => [
                'required',
                'string'
            ],
            'have_factory' => [
                "required",
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ],
            /** additional information of industry */
            'is_proprietorship' => [
                'required',
                'integer',
                Rule::in(array_keys(SmefMember::PROPRIETORSHIP_LIST))
            ],
            'date_of_establishment' => 'required|date_format:Y-m-d',
            'trade_licensing_authority' => [
                'required',
                'int',
                Rule::in(array_keys(SmefMember::TRADE_LICENSING_AUTHORITY))
            ],
            'trade_license_path' => "required|string",
            'trade_license_last_renew_year' => 'required|string|max:4',
            'have_tin' => [
                "required",
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ],
            'investment_amount' => 'required|numeric',
            'current_total_asset' => 'nullable|numeric',

            'is_registered_under_authority' => [
                "required",
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ],
            'registered_authority' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->get('is_registered_under_authority') == BaseModel::BOOLEAN_TRUE;
                }),
                'nullable',
                'array'
            ],
            'registered_authority.*.authority_type' => [
                'required',
                'integer',
                Rule::in(array_keys(SmefMember::REGISTERED_AUTHORITY))
            ],
            'registered_authority.*.registration_number' => [
                'required',
                'string'
            ],

            'is_authorized_under_authority' => [
                "required",
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ],
            'authorized_authority' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->get('is_authorized_under_authority') == BaseModel::BOOLEAN_TRUE;
                }),
                'array',
            ],
            'authorized_authority.*.authority_type' => [
                'required',
                "integer",
                Rule::in(array_keys(SmefMember::AUTHORIZED_AUTHORITY))
            ],
            'authorized_authority.*.registration_number' => [
                'required',
                "string"
            ],
            'have_specialized_area' => [
                "required",
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ],
            'specialized_area' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->get('have_specialized_area') == BaseModel::BOOLEAN_TRUE;
                }),
                'nullable',
                'array',
            ],
            'is_under_sme_cluster' => [
                "required",
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ],
            'under_sme_cluster_id' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->get('is_under_sme_cluster') == BaseModel::BOOLEAN_TRUE;
                }),
                'nullable',
                'integer',
                'exists:smef_clusters,id,deleted_at,NULL'
            ],
            'is_under_of_association_or_chamber' => [
                "required",
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ],
            'under_association_or_chamber_name' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->get('is_under_of_association_or_chamber') == BaseModel::BOOLEAN_TRUE;
                }),
                'nullable',
                "string"
            ],
            'under_association_or_chamber_name_en' => [
                'nullable',
                "string"
            ],
            'sector_id' => [
                'required',
                Rule::in(array_keys(SmefMember::SECTOR))
            ],
            'other_sector_name' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->get('sector_id') == SmefMember::OTHER_SECTOR_KEY;
                }),
                'string'
            ],
            'other_sector_name_en' => 'nullable|string|max:191',

            'business_type' => [
                'required',
                'int',
                Rule::in(array_keys(SmefMember::BUSINESS_TYPE))
            ],
            'main_product_name' => 'required|string|max:191',
            'main_product_name_en' => 'nullable|string|max:191',
            'main_material_description' => [
                'required',
                'string',
                'max:5000'
            ],
            'main_material_description_en' => [
                'nullable',
                'string',
                'max:5000'
            ],

            'is_import' => [
                "required",
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ],
            'import_type' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->get('is_import') == BaseModel::BOOLEAN_TRUE;
                }),
                'nullable',
                'array'
            ],
            'import_type.*' => [
                'required',
                'integer',
                Rule::in(array_keys(SmefMember::IMPORT_EXPORT_TYPE))
            ],
            'is_export' => [
                "required",
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ],
            'export_type' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->get('is_export') == BaseModel::BOOLEAN_TRUE;
                }),
                'nullable',
                'array'
            ],
            'export_type.*' => [
                'required',
                'integer',
                Rule::in(array_keys(SmefMember::IMPORT_EXPORT_TYPE))
            ],
            'industry_irc_no' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->get('is_export') == BaseModel::BOOLEAN_TRUE;
                }),
                'nullable',
                'string'
            ],
            'salaried_manpower' => [
                'nullable',
                'array'
            ],
            'salaried_manpower.' . SmefMember::PERMANENT_WORKER_KEY => [
                'required',
                'array'
            ],
            'salaried_manpower.' . SmefMember::PERMANENT_WORKER_KEY . '.' . SmefMember::MANPOWER_TYPE_MALE => [
                'nullable',
                'integer'
            ],
            'salaried_manpower.' . SmefMember::PERMANENT_WORKER_KEY . '.' . SmefMember::MANPOWER_TYPE_FEMALE => [
                'nullable',
                'integer'
            ],
            'salaried_manpower.' . SmefMember::TEMPORARY_WORKER_KEY => [
                'required',
                'array'
            ],
            'salaried_manpower.' . SmefMember::TEMPORARY_WORKER_KEY . '.' . SmefMember::MANPOWER_TYPE_MALE => [
                'nullable',
                'integer'
            ],
            'salaried_manpower.' . SmefMember::TEMPORARY_WORKER_KEY . '.' . SmefMember::MANPOWER_TYPE_FEMALE => [
                'nullable',
                'integer'
            ],
            'salaried_manpower.' . SmefMember::SEASONAL_WORKER_KEY => [
                'required',
                'array'
            ],
            'salaried_manpower.' . SmefMember::SEASONAL_WORKER_KEY . '.' . SmefMember::MANPOWER_TYPE_MALE => [
                'nullable',
                'integer'
            ],
            'salaried_manpower.' . SmefMember::SEASONAL_WORKER_KEY . '.' . SmefMember::MANPOWER_TYPE_FEMALE => [
                'nullable',
                'integer'
            ],
            'have_bank_account' => [
                "required",
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ],
            'bank_account_type' => [
                Rule::requiredIf(function () use ($request) {
                    return $request->get('have_bank_account') == BaseModel::BOOLEAN_TRUE;
                }),
                'nullable',
                'array'
            ],

            'have_daily_accounting_system' => [
                "required",
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ],
            'use_computer' => [
                "required",
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ],
            'have_internet_connection' => [
                "required",
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ],
            'have_online_business' => [
                "required",
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ],
            'industry_association_id' => [
                'required',
                'int',
                'exists:industry_associations,id,deleted_at,NULL'
            ],
            'permission_sub_group_id' => [
                'nullable',
                'integer'
            ],

        ];
        /** other Authority */
        if (!empty($request->get('other_authority')) && is_array($request->get('other_authority'))) {
            $rules['other_authority.' . 'authority_type'] = [
                "required",
                "string",
                Rule::in([SmefMember::OTHER_AUTHORITY_KEY])
            ];
            $rules['other_authority.' . 'authority_name'] = [
                "required",
                "string"
            ];
            $rules['other_authority.' . 'registration_number'] = [
                "required",
                "string"
            ];
        }

        /** Bank Account Type */
        if (!empty($request->get('bank_account_type'))) {
            $rules['bank_account_type.' . SmefMember::BANK_ACCOUNT_PERSONAL] = [
                'required',
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ];
            $rules['bank_account_type.' . SmefMember::BANK_ACCOUNT_INDUSTRY] = [
                'required',
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ];
        }

        if (!empty($request->get('form_fill_up_by')) && $request->get('form_fill_up_by') == SmefMember::FORM_FILL_UP_BY_SMEF_CLUSTER) {
            $rules['smef_cluster_name'] = 'required|string|max: 100';
            $rules['smef_cluster_loc_district_id'] = [
                'required',
                'integer',
                'exists:loc_districts,id,deleted_at,NULL'
            ];
            $rules['smef_cluster_union_id'] = [
                'required',
                'integer',
                'exists:loc_unions,id,deleted_at,NULL'
            ];
            $rules['smef_cluster_code'] = 'required|string|max: 255';

            /** info_provider  information */
            $rules['info_provider_name'] = 'required|string|max:100';
            $rules['info_provider_mobile'] = [
                "required",
                BaseModel::MOBILE_REGEX
            ];
            $rules['info_collector_name'] = 'required|string|max:100';
            $rules['info_collector_mobile'] = [
                "required",
                BaseModel::MOBILE_REGEX
            ];

        }

        if (!empty($request->get('form_fill_up_by') == SmefMember::FORM_FILL_UP_BY_CHAMBER_OR_ASSOCIATION)) {
            $rules['chamber_or_association_name'] = 'required|string|max: 100';
            $rules['chamber_or_association_loc_district_id'] = [
                'nullable',
                'integer',
                'exists:loc_districts,id,deleted_at,NULL'
            ];
            $rules['chamber_or_association_union_id'] = [
                'required',
                'integer',
                'exists:loc_unions,id,deleted_at,NULL'
            ];
            $rules['chamber_or_association_code'] = 'required|string|max: 255';

            /** info_provider  information */
            $rules['info_provider_name'] = 'required|string|max:100';
            $rules['info_provider_mobile'] = [
                "required",
                BaseModel::MOBILE_REGEX
            ];
            $rules['info_collector_name'] = 'required|string|max:100';
            $rules['info_collector_mobile'] = [
                "required",
                BaseModel::MOBILE_REGEX
            ];
        }

        /** If Industry has factory then the fields are required */
        if ($request->get('have_factory') == BaseModel::BOOLEAN_TRUE) {
            $rules["factory_address"] = "required|string|max:1200";
            $rules["factory_address_en"] = "nullable|string|max:800";
            $rules['factory_loc_division_id'] = [
                'required',
                'integer',
                'exists:loc_divisions,id,deleted_at,NULL'
            ];
            $rules['factory_loc_district_id'] = [
                'required',
                'integer',
                'exists:loc_districts,id,deleted_at,NULL'
            ];
            $rules['factory_loc_upazila_id'] = [
                'required',
                'integer',
                'exists:loc_upazilas,id,deleted_at,NULL'
            ];
            $rules["factory_web_site"] = "nullable|string|max:255";

            $rules["have_own_land"] = [
                "required",
                Rule::in(array_keys(SmefMember::LAND_TYPE))
            ];
            $rules['have_office_or_showroom'] = [
                "required",
                Rule::in([BaseModel::BOOLEAN_TRUE, BaseModel::BOOLEAN_FALSE])
            ];
        }
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
            'title_en' => 'nullable|max:600|min:2',
            'title' => 'nullable|max:1200|min:2',
            'page' => 'integer|gt:0',
            'page_size' => 'integer|gt:0',
            'trade_id' => 'nullable|integer|gt:0',
            'order' => [
                'string',
                Rule::in([BaseModel::ROW_ORDER_ASC, BaseModel::ROW_ORDER_DESC])
            ],
            'row_status' => [
                "nullable",
                "integer",
                Rule::in(IndustryAssociation::ROW_STATUSES),
            ],
        ], $customMessage);
    }


}
