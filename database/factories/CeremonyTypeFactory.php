<?php

namespace Database\Factories;

use App\Models\CeremonyType;
use Illuminate\Database\Eloquent\Factories\Factory;

class CeremonyTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CeremonyType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->word,
        ];
    }
}
