<?php

namespace Database\Factories;

use App\Models\DeceasedProfile;
use App\Models\Employee;
use App\Models\Office;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeceasedProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DeceasedProfile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'birthday' => $this->faker->date,
            'death' => $this->faker->date,
            'adviser_id' => Employee::factory(),
            'office_id' => Office::factory(),
        ];
    }
}
