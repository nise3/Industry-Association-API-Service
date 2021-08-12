<?php

namespace Database\Factories;

use App\Models\HumanResource;
use App\Models\HumanResourceTemplate;
use App\Models\Organization;
use App\Models\OrganizationUnit;
use App\Models\Rank;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

class HumanResourceFactory extends Factory
{
    protected $model = HumanResource::class;

    public function definition(): array
    {
        $title = $this->faker->randomElement(["Marketing", "Sales executive"]);

        $organization = Organization::all()->random();
        $organizationUnit= OrganizationUnit::all()->random();
        $humanResourceTemplate = HumanResourceTemplate::all()->random();
        $parent = HumanResource::inRandomOrder()->first();
        $skill = Skill::all()->toArray();
        $rank = Rank::all()->random();

        return [
            'organization_id' => $organization->id,
            'organization_unit_id'=>$organizationUnit->id,
            'human_resource_template_id'=>$humanResourceTemplate->id,
            'rank_id'=>$rank->id,
            'parent_id'=>$parent?$parent->id:null,
            'skill_ids'=>array_rand($skill,2),
            'display_order'=>$this->faker->randomDigit(),
            'is_designation'=>1,
            'status'=>1,
            'title_en'=>$title,
            'title_bn'=>$title,
        ];
    }
}