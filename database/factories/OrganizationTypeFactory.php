<?php

namespace Database\Factories;

use App\Models\OrganizationType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class OrganizationTypeFactory
 * @package Database\Factories
 */
class OrganizationTypeFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = OrganizationType::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $title = $this->faker->randomElement(["Government org", "private org"]);

        return [
            'title_en' => $title,
            'title_bn' => $title,
            'is_government' => $this->faker->randomElement([0, 1]),
        ];
    }
}
