<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BenificiaryProjectArea;

class BenificiaryProjectAreaFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = BenificiaryProjectArea::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'benificiary_uuid' => \App\Models\Benificiary::factory(),
            'project_area_uuid' => \App\Models\ProjectArea::factory(),
        ];
    }
}
