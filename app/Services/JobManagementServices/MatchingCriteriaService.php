<?php

namespace App\Services\JobManagementServices;


use App\Models\BaseModel;
use App\Models\CompanyInfoVisibility;
use App\Models\MatchingCriteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MatchingCriteriaService
{
    /**
     * @param string $jobId
     * @return MatchingCriteria|null
     */
    public function getMatchingCriteria(string $jobId): MatchingCriteria|null
    {
        /** @var MatchingCriteria| Builder $matchingCriteriaBuilder */
        $matchingCriteriaBuilder = MatchingCriteria::select([
            'matching_criteria.id',
            'matching_criteria.job_id',
            'matching_criteria.is_age_enabled',
            'matching_criteria.is_total_year_of_experience_enabled',
            'matching_criteria.is_gender_enabled',
            'matching_criteria.is_area_of_experience_enabled',
            'matching_criteria.is_skills_enabled',
            'matching_criteria.is_job_location_enabled',
            'matching_criteria.is_salary_enabled',
            'matching_criteria.is_area_of_business_enabled',
            'matching_criteria.is_job_level_enabled',
            'matching_criteria.is_age_mandatory',
            'matching_criteria.is_total_year_of_experience_mandatory',
            'matching_criteria.is_gender_mandatory',
            'matching_criteria.is_job_location_mandatory',
        ]);

        $matchingCriteriaBuilder->where('matching_criteria.job_id', $jobId);

        $this->buildRelations($matchingCriteriaBuilder);

        return $matchingCriteriaBuilder->first();
    }

    /**
     * @param string $jobId
     * @return MatchingCriteria|null
     */
    public function getMatchingCriteriaRelatedInfo(string $jobId): CompanyInfoVisibility|null
    {
        /** @var CompanyInfoVisibility| Builder $matchingCriteriaRelatedInfoBuilder */
        $matchingCriteriaRelatedInfoBuilder = CompanyInfoVisibility::select([
            'company_info_visibilities.job_id',
        ]);

        $matchingCriteriaRelatedInfoBuilder->where('company_info_visibilities.job_id', $jobId);

        $this->buildRelations($matchingCriteriaRelatedInfoBuilder);

        return $matchingCriteriaRelatedInfoBuilder->first();
    }

    /**
     * @param MatchingCriteria|CompanyInfoVisibility|null
     * @return MatchingCriteria|CompanyInfoVisibility|null
     */
    public function buildRelations($matchingCriteriaBuilder): Builder|MatchingCriteria|CompanyInfoVisibility|null
    {
        $matchingCriteriaBuilder->with('areaOfExperiences');//:id,title_en
        $matchingCriteriaBuilder->with('areaOfBusiness');//:id,title,title_en
        $matchingCriteriaBuilder->with('skills');//:id,title,title_en
        $matchingCriteriaBuilder->with('genders:job_id,gender_id');
        $matchingCriteriaBuilder->with('candidateRequirement:job_id,minimum_year_of_experience,maximum_year_of_experience,age_minimum,age_maximum');
        $matchingCriteriaBuilder->with('additionalJobInformation:job_id,salary_min,salary_max');
        $matchingCriteriaBuilder->with('jobLevels:job_id,job_level_id');
        $matchingCriteriaBuilder->with('jobLocations');

        return $matchingCriteriaBuilder;
    }

    /**
     * @param array $data
     * @return MatchingCriteria
     */
    public function store(array $data): MatchingCriteria
    {
        return MatchingCriteria::updateOrCreate(
            ['job_id' => $data['job_id']],
            $data
        );
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $requestData = $request->all();
        $rules = [
            "job_id" => [
                "required",
                "string",
                "exists:company_info_visibilities,job_id,deleted_at,NULL",
            ],
            "is_age_enabled" => [
                "nullable",
                "integer",
                Rule::in(array_keys(BaseModel::BOOLEAN_FLAG))
            ],
            "is_total_year_of_experience_enabled" => [
                "nullable",
                "integer",
                Rule::in(array_keys(BaseModel::BOOLEAN_FLAG))
            ],
            "is_gender_enabled" => [
                "nullable",
                "integer",
                Rule::in(array_keys(BaseModel::BOOLEAN_FLAG))
            ],
            "is_area_of_experience_enabled" => [
                "nullable",
                "integer",
                Rule::in(array_keys(BaseModel::BOOLEAN_FLAG))
            ],
            "is_skills_enabled" => [
                "integer",
                "numeric",
                Rule::in(array_keys(BaseModel::BOOLEAN_FLAG))
            ],
            "is_job_location_enabled" => [
                "nullable",
                "integer",
                Rule::in(array_keys(BaseModel::BOOLEAN_FLAG))
            ],
            "is_salary_enabled" => [
                "nullable",
                "integer",
                Rule::in(array_keys(BaseModel::BOOLEAN_FLAG))
            ],
            "is_area_of_business_enabled" => [
                "nullable",
                "integer",
                Rule::in(array_keys(BaseModel::BOOLEAN_FLAG))
            ],
            "is_job_level_enabled" => [
                "nullable",
                "integer",
                Rule::in(array_keys(BaseModel::BOOLEAN_FLAG))
            ],
            "is_age_mandatory" => [
                "nullable",
                "integer",
                Rule::in(array_keys(BaseModel::BOOLEAN_FLAG))
            ],
            "is_total_year_of_experience_mandatory" => [
                "nullable",
                "integer",
                Rule::in(array_keys(BaseModel::BOOLEAN_FLAG))
            ],
            "is_gender_mandatory" => [
                "nullable",
                "integer",
                Rule::in(array_keys(BaseModel::BOOLEAN_FLAG))
            ],
            "is_job_location_mandatory" => [
                "nullable",
                "integer",
                Rule::in(array_keys(BaseModel::BOOLEAN_FLAG))
            ],
        ];

        return Validator::make($requestData, $rules);
    }


}
