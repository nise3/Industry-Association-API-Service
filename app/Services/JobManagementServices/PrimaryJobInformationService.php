<?php

namespace App\Services\JobManagementServices;


use App\Models\EmploymentType;
use App\Models\PrimaryJobInformation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PrimaryJobInformationService
{


    public function getPrimaryJobInformationDetails(string $jobId): Model|Builder
    {
        /** @var Builder $primaryJobInformationBuilder */
        $primaryJobInformationBuilder = PrimaryJobInformation::select([
            'primary_job_information.id',
            'primary_job_information.job_id',
            'primary_job_information.service_type',
            'primary_job_information.job_title',
            'primary_job_information.no_of_vacancies',
            'primary_job_information.job_category_id',
            'primary_job_information.application_deadline',
            'primary_job_information.resume_receiving_option',
            'primary_job_information.email',
            'primary_job_information.is_use_nise3_mail_system',
            'primary_job_information.special_instruction_for_job_seekers',
            'primary_job_information.instruction_for_hard_copy',
            'primary_job_information.instruction_for_walk_in_interview',
            'primary_job_information.is_photograph_enclose_with_resume',
            'primary_job_information.is_prefer_video_resume',
            'primary_job_information.created_at',
            'primary_job_information.updated_at',
        ]);

        $primaryJobInformationBuilder->where('primary_job_information.job_id', $jobId);

        $primaryJobInformationBuilder->with('employmentTypes');

        return $primaryJobInformationBuilder->firstOrFail();
    }

    /**
     * @param array $data
     * @return PrimaryJobInformation
     */
    public function store(array $data): PrimaryJobInformation
    {
        return PrimaryJobInformation::updateOrCreate(
            ['job_id' => $data['job_id']],
            $data
        );
    }

    /**
     * @param PrimaryJobInformation $primaryJobInformation
     * @param array $employmentTypes
     */
    public function syncWithEmploymentStatus(PrimaryJobInformation $primaryJobInformation, array $employmentTypes)
    {
        $employmentTypeId = EmploymentType::whereIn('id', $employmentTypes)->pluck('id')->toArray();
        if (!empty($employmentTypeId)) {
            $primaryJobInformation->employmentTypes()->sync($employmentTypes);
        }
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            "job_id" => [
                "required",
                "string"
            ],
            "service_type" => [
                "required",
                Rule::in(array_keys(PrimaryJobInformation::JOB_SERVICE_TYPE))
            ],
            "job_title" => [
                "required",
                "string"
            ],
            "is_not_vacancy_needed" => [
                "required",
                Rule::in(array_keys(PrimaryJobInformation::BOOLEAN_FLAG))
            ],
            "no_of_vacancies" => [
                Rule::requiredIf(function () use ($request) {
                    return $request->is_not_vacancy_needed != PrimaryJobInformation::VACANCY_NOT_NEEDED;
                }),
                "nullable",
                "integer"
            ],
            "job_category_id" => [
                "required",
                "exists:occupations,id"
            ],
            "employment_type" => [
                "required",
                "array"
            ],
            "employment_type.*" => [
                "required",
                "exists:employment_types,id"
            ],
            "application_deadline" => [
                "required",
                "date"
            ],
            "resume_receiving_option" => [
                "required",
                Rule::in(array_keys(PrimaryJobInformation::RESUME_RECEIVING_OPTION))
            ],
            "email" => [
                Rule::requiredIf(function () use ($request) {
                    return $request->resume_receiving_option == PrimaryJobInformation::RESUME_RECEIVING_OPTION[2];
                }),
                "nullable",
                "email"
            ],
            "is_use_nise3_mail_system" => [
                "nullable"
            ],
            "special_instruction_for_job_seekers" => [
                "nullable"
            ],
            "instruction_for_hard_copy" => [
                Rule::requiredIf(function () use ($request) {
                    return $request->resume_receiving_option == PrimaryJobInformation::RESUME_RECEIVING_OPTION[3];
                }),
                "nullable"
            ],
            "instruction_for_walk_in_interview" => [
                Rule::requiredIf(function () use ($request) {
                    return $request->resume_receiving_option == PrimaryJobInformation::RESUME_RECEIVING_OPTION[4];
                }),
                "nullable"
            ],
            "is_photograph_enclose_with_resume" => [
                "required",
                Rule::in(array_keys(PrimaryJobInformation::BOOLEAN_FLAG))
            ],
            "is_prefer_video_resume" => [
                Rule::requiredIf(function () use ($request) {
                    return $request->resume_receiving_option == PrimaryJobInformation::RESUME_RECEIVING_OPTION[1];
                }),
                "nullable",
                Rule::in(array_keys(PrimaryJobInformation::BOOLEAN_FLAG))
            ]
        ];

        return Validator::make($request->all(), $rules);
    }


}
