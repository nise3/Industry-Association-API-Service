<?php

namespace App\Services;

use App\Models\IndustryAssociation;
use App\Models\Organization;
use JetBrains\PhpStorm\ArrayShape;

class StatisticsService
{

    #[ArrayShape(['total_industry' => "int", 'total_job_provider' => "array", 'total_industry_association' => "int"])]
    public function getNiseStatistics(): array
    {
        return [
            'total_industry' => $this->getTotalIndustry(),
            'total_job_provider' => $this->getTotalIndustryAssociationWithProvidedJobs(),
            'total_industry_association' => $this->getTotalIndustryAssociation()
        ];
    }

    private function getTotalIndustry(): int
    {
        return Organization::count('id');
    }

    private function getTotalIndustryAssociation(): int
    {
        return IndustryAssociation::count('id');
    }

    private function getTotalIndustryAssociationWithProvidedJobs(): array
    {
        $builder = IndustryAssociation::query();
        $builder->select([
            "industry_associations.title as industry_associations_title"
        ]);

        $builder->selectRaw('COUNT(primary_job_information.id) AS total_job_provided');
        $builder->join('primary_job_information', 'primary_job_information.industry_association_id', "industry_associations.id");
        $builder->whereNotNull('primary_job_information.published_at');
        $builder->groupBy('primary_job_information.industry_association_id');
        $builder->orderBy('total_job_provided', "DESC");

        return $builder->limit(4)->get()->toArray();
    }
}
