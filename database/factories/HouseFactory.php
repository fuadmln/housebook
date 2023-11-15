<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\User;
use App\Models\Province;
use App\Models\Subdistrict;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\House>
 */
class HouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all('id')->random(),
            'province_id' => Province::all('id')->random(),
            'city_id' => City::all('id')->random(),
            'subdistrict_id' => Subdistrict::all('id')->random(),
            'price' => fake()->numberBetween(100, 200) * 1000000 ,
            'address' => fake()->address(),
            'description' => fake()->paragraph(1),
            'type' => fake()->numberBetween(0, 1),
            'building_area' => fake()->numberBetween(30, 90),
            'land_length' => fake()->numberBetween(5, 10),
            'land_width' => fake()->numberBetween(5, 10),
            'bedroom' => fake()->numberBetween(0, 5),
            'bathroom' => fake()->numberBetween(0, 3),
            'floor' => fake()->numberBetween(0, 3),
            'headline' => fake()->paragraph(3),
            'iframe' => fake()->sentence(5) ,
        ];
    }
}
