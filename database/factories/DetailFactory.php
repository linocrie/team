<?php

namespace Database\Factories;

use App\Models\Detail;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Detail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'phone'   => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'city'    => $this->faker->city,
            'country' => $this->faker->country
        ];
    }
}
