<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'thumbnail' => 'projects/'.fake()->uuid().'.webp',
            'content' => fake()->paragraphs(3, true),
            'demo_url' => fake()->optional()->url(),
            'github_url' => fake()->optional()->url(),
            'sort_order' => fake()->numberBetween(0, 100),
            'is_active' => true,
            'published_at' => fake()->date(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
            'published_at' => now(),
        ]);
    }
}
