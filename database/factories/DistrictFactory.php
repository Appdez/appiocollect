<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\District;

class DistrictFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = District::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'deleted_at' => $this->faker->dateTime(),
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->name(),
        ];
    }
}
