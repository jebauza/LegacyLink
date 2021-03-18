<?php

namespace Database\Factories;

use App\Models\Office;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class OfficeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Office::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'cif' => Str::random(7),
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'cp' => $this->faker->postcode,
            'province' => $this->faker->state,
            'country' => $this->faker->country,
            'timezone_id' => rand(1,93),
            'phone' => $this->faker->phoneNumber,
            'contact_person' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
