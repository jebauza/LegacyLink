<?php

namespace Database\Factories;

use App\Models\Ceremony;
use App\Models\CeremonyType;
use App\Models\DeceasedProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class CeremonyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ceremony::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'main' => $this->faker->boolean,
            'start' => $this->faker->date,
            'end' => $this->faker->date,
            'room_name' => $this->faker->word,
            'additional_info' => $this->faker->sentence,
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'ceremony_type_id' => CeremonyType::factory(),
        ];
    }
}
