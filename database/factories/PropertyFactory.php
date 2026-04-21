<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $types = ['apartamento', 'casa', 'vivenda', 'terreno', 'armazem', 'escritorio', 'loja', 'edificio', 'fazenda', 'outro'];
        $purposes = ['sale', 'rent'];
        $cities = ['Luanda', 'Talatona', 'Zango', 'Viana', 'Benfica', 'Kilamba', 'Lobito', 'Benguela', 'Huambo', 'Lubango'];

        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->randomFloat(2, 50000, 5000000),
            'currency' => fake()->randomElement(['AOA', 'USD', 'EUR']),
            'bedrooms' => fake()->numberBetween(0, 6),
            'bathrooms' => fake()->numberBetween(0, 4),
            'area' => fake()->numberBetween(50, 1000),
            'purpose' => fake()->randomElement($purposes),
            'property_type' => fake()->randomElement($types),
            'address' => fake()->address(),
            'city' => fake()->randomElement($cities),
            'is_active' => true,
        ];
    }
}
