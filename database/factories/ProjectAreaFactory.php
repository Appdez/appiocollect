<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProjectArea;

class ProjectAreaFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = ProjectArea::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'deleted_at' => $this->faker->dateTime(),
            'name' => $this->faker->name,
            'uuid' => $this->faker->uuid,
        ];
    }
}
