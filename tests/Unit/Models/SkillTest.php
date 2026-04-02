<?php

use App\Models\Project;
use App\Models\Skill;

test('skill can be created with factory', function () {
    $skill = Skill::factory()->create();

    expect($skill)->toBeInstanceOf(Skill::class)
        ->and($skill->id)->toBeInt()
        ->and($skill->name)->toBeString();
});

test('skill has correct attributes', function () {
    $skill = Skill::factory()->create([
        'name' => 'PHP',
        'category' => 'backend',
    ]);

    expect($skill->name)->toBe('PHP')
        ->and($skill->category)->toBe('backend');
});

test('skill has projects relationship', function () {
    $skill = Skill::factory()->create();
    $project = Project::factory()->create();

    $skill->projects()->attach($project);

    expect($skill->projects)->toHaveCount(1)
        ->and($skill->projects->first())->toBeInstanceOf(Project::class);
});

test('skill can belong to multiple projects', function () {
    $skill = Skill::factory()->create();
    $projects = Project::factory()->count(3)->create();

    $skill->projects()->attach($projects);

    expect($skill->projects)->toHaveCount(3);
});
