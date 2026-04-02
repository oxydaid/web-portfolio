<?php

namespace Database\Factories;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Skill>
 */
class SkillFactory extends Factory
{
    protected $model = Skill::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'Laravel', 'Vue.js', 'React', 'PHP', 'JavaScript',
                'TypeScript', 'Python', 'Docker', 'MySQL', 'PostgreSQL',
                'Redis', 'Tailwind CSS', 'Node.js', 'Git', 'AWS',
            ]),
            'icon' => null,
            'category' => fake()->randomElement(['frontend', 'backend', 'tools', 'database']),
        ];
    }
}
