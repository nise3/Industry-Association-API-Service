<?php

namespace App\Services;

use App\Models\BaseModel;
use App\Models\IndustryAssociation;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 *
 */
class IndustryAssociationService
{

    /**
     * @param IndustryAssociation $industryAssociation
     * @param array $data
     * @return IndustryAssociation
     */
    public function store(IndustryAssociation $industryAssociation, array $data): IndustryAssociation
    {
        $industryAssociation->fill($data);
        $industryAssociation->save();
        return $industryAssociation;
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
        return $industryAssociation;
    }

    /**
     * @param IndustryAssociation $industryAssociation
     * @return bool
     */
    public function destroy(IndustryAssociation $industryAssociation): bool
    {
        return $industryAssociation->delete();
    }

    /**
     * @param IndustryAssociation $industryAssociation
     * @return bool
     */
    public function restore(IndustryAssociation $industryAssociation): bool
    {
        return $industryAssociation->restore();
    }

    /**
     * industryAssociation validator
     * @param array $data
     * @return mixed|null
     * @throws RequestException
     */
    public function createUser(array $data): array|null
    {
        $url = clientUrl(BaseModel::CORE_CLIENT_URL_TYPE) . 'admin-user-create';
        $userPostField = [
            'permission_sub_group_id' => $data['permission_sub_group_id'] ?? "",
            'user_type' => BaseModel::INDUSTRY_ASSOCIATION_USER_TYPE,
            'industry_association_id' => $data['industry_association_id'] ?? "",
            'username' => $data['contact_person_mobile'] ?? "",
            'name_en' => $data['contact_person_name'] ?? "",
            'name' => $data['contact_person_name'] ?? "",
            'email' => $data['contact_person_email'] ?? "",
            'mobile' => $data['contact_person_mobile'] ?? ""
        ];

        return Http::withOptions(
            [
                'verify' => config('nise3.should_ssl_verify'),
                'debug' => config('nise3.http_debug'),
                'timeout' => config('nise3.http_timeout'),
            ])
            ->post($url, $userPostField)
            ->throw(function ($response, $e) use ($url) {
                Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . json_encode($response));
                return $e;
            })
            ->json();
    }


    /**
     * @param array $data
     * @return array|null
     * @throws RequestException
     */
    public function createOpenRegisterUser(array $data): array|null
    {
        $url = clientUrl(BaseModel::CORE_CLIENT_URL_TYPE) . 'user-open-registration';

        $userPostField = [
            'user_type' => BaseModel::INDUSTRY_ASSOCIATION_USER_TYPE,
            'username' => $data['contact_person_mobile'] ?? "",
            'industry_association_id' => $data['organization_id'] ?? "",
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
                'debug' => config('nise3.http_debug'),
                'timeout' => config('nise3.http_timeout'),
            ])
            ->post($url, $userPostField)
            ->throw(function ($response, $e) use ($url) {
                Log::debug("Http/Curl call error. Destination:: " . $url . ' and Response:: ' . json_encode($response));
                throw $e;
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
        $customMessage = [
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
        ];

        $rules = [
            'industry_association_type_id' => [
                'required',
                'int',
                Rule::in(IndustryAssociation::INDUSTRY_ASSOCIATION_TYPES)
            ],
            'permission_sub_group_id' => [
                Rule::requiredIf(function () use ($id) {
                    return is_null($id);
                }),
                'nullable',
                'integer'
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
                'integer',
            ],
            'address' => [
                'nullable',
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
                'max:191'
            ],
            'fax_no' => [
                'nullable',
                'string',
                'max: 30',
            ],
            'trade_number' => [
                'required',
                'string',
                'max:100'
            ],
            "name_of_the_office_head" => [
                "required",
                "string",
                'max:600'
            ],
            "name_of_the_office_head_en" => [
                "nullable",
                "string",
                'max:600'
            ],
            "name_of_the_office_head_designation" => [
                "required",
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
                Rule::unique('industry_associations', 'contact_person_mobile')
                    ->ignore($id)
                    ->where(function (\Illuminate\Database\Query\Builder $query) {
                        return $query->whereNull('deleted_at');
                    }),
                BaseModel::MOBILE_REGEX,

            ],
            'contact_person_email' => [
                'required',
                'email',
                'max:191'
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
            'domain' => [
                'nullable',
                'regex:/^(http|https):\/\/[a-zA-Z-\-\.0-9]+$/',
                'string',
                'max:191',
                Rule::unique('industry_associations', 'domain')
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
                Rule::in(IndustryAssociation::ROW_STATUSES),
            ],
        ];
        return Validator::make($request->all(), $rules, $customMessage);
    }


    /**
     * industryAssociation open registration validation
     * @param Request $request
     * @return mixed
     */
    public function industryAssociationRegistrationValidator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $customMessage = [
            'row_status.in' => 'Row status must be within 1 or 0. [30000]'
        ];

        $rules = [
            'industry_association_type_id' => [
                'required',
                'int',
                Rule::in(IndustryAssociation::INDUSTRY_ASSOCIATION_TYPES)
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
            'trade_number' => [
                'required',
                'string',
                'max:100'
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
            "name_of_the_office_head" => [
                "required",
                "string",
                'max:600'
            ],
            "name_of_the_office_head_en" => [
                "nullable",
                "string",
                'max:600'
            ],
            "name_of_the_office_head_designation" => [
                "required",
                "string"
            ],
            "name_of_the_office_head_designation_en" => [
                "nullable",
                "string"
            ],
            'address' => [
                'nullable',
                'max: 1200',
                'min:2'
            ],
            'address_en' => [
                'nullable',
                'max: 600',
                'min:2'
            ],
            'mobile' => [
                'required',
                BaseModel::MOBILE_REGEX,
            ],
            'email' => [
                'required',
                'email',
                'max:191'
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
                Rule::unique('industry_associations', 'contact_person_mobile')
                    ->where(function (\Illuminate\Database\Query\Builder $query) {
                        return $query->whereNull('deleted_at');
                    }),
                BaseModel::MOBILE_REGEX,
            ],
            'contact_person_email' => [
                'required',
                'email',
                'max:191'
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
            "password" => [
                "required",
                "confirmed",
                Password::min(BaseModel::PASSWORD_MIN_LENGTH)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
            "password_confirmation" => 'required_with:password',
        ];
        return Validator::make($request->all(), $rules, $customMessage);
    }


}
