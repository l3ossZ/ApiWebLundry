<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\ServiceRate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'service_rate_id'=>ServiceRate::inRandomOrder()->first()->id,
            'clothType'=>fake()->randomElement(['เสื้อยืด','เสื้อยืดแขนยาว','กางเกงขาสั้น','กางเกงขายาว']),
            'addOnPrice'=>fake()->numberBetween(0,0),
            


        ];
    }
}
