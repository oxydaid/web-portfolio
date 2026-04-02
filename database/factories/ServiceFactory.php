<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        return [
            'title' => fake()->randomElement([
                'Web Development', 'Mobile Development', 'UI/UX Design',
                'API Development', 'Database Design', 'DevOps',
            ]),
            'icon' => null,
            'short_description' => fake()->sentence(10),
            'price_start_from' => fake()->numberBetween(1000000, 50000000),
            'sort_order' => fake()->numberBetween(0, 10),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
