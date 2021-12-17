<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Benificiary;

class BenificiaryFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Benificiary::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'full_name' => $this->faker->name,
            'age' => $this->faker->randomNumber(),
            'qualification' => $this->faker->word,
            'form_number' => $this->faker->randomNumber(),
            'zone' => $this->faker->word,
            'location' => $this->faker->word,
            'district_uuid' => \App\Models\District::all()->random(2)->first(),
            'benefit_uuid' => \App\Models\Benefit::all()->random(2)->first(),
            'project_area_uuid' => \App\Models\ProjectArea::all()->random(2)->first(),
            'genre_uuid' => \App\Models\Genre::all()->random(2)->first(),
        ];
    }
}
