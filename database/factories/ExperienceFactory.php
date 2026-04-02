<?php

namespace Database\Factories;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Experience>
 */
class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-5 years', '-1 year');

        return [
            'company_name' => fake()->company(),
            'role' => fake()->jobTitle(),
            'start_date' => $startDate,
            'end_date' => fake()->dateTimeBetween($startDate, 'now'),
            'is_current' => false,
            'description' => fake()->paragraph(),
            'type' => fake()->randomElement(['work', 'education']),
        ];
    }

    public function current(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_current' => true,
            'end_date' => null,
        ]);
    }
}
