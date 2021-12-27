<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BenificiaryBenefit;

class BenificiaryBenefitFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = BenificiaryBenefit::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'benificiary_uuid' => \App\Models\Benificiary::all()->random(1)->first(),
            'benefit_uuid' => \App\Models\Benefit::all()->random(1)->first(),
        ];
    }
}
