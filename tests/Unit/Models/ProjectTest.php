<?php

use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;

test('project can be created with factory', function () {
    $project = Project::factory()->create();

    expect($project)->toBeInstanceOf(Project::class)
        ->and($project->id)->toBeInt()
        ->and($project->title)->toBeString()
        ->and($project->slug)->toBeString();
});

test('project has correct fillable behavior with guarded', function () {
    $project = Project::factory()->create([
        'title' => 'Test Project',
        'slug' => 'test-project',
    ]);

    expect($project->title)->toBe('Test Project')
        ->and($project->slug)->toBe('test-project');
});

test('project casts are correct', function () {
    $project = Project::factory()->create([
        'is_active' => 1,
        'published_at' => '2025-01-01',
    ]);

    expect($project->is_active)->toBeBool()
        ->and($project->published_at)->toBeInstanceOf(Carbon::class);
});

test('project has skills relationship', function () {
    $project = Project::factory()->create();
    $skill = Skill::factory()->create(['name' => 'Laravel']);

    $project->skills()->attach($skill);

    expect($project->skills)->toHaveCount(1)
        ->and($project->skills->first()->name)->toBe('Laravel');
});

test('project can have multiple skills', function () {
    $project = Project::factory()->create();
    $skills = Skill::factory()->count(3)->create();

    $project->skills()->attach($skills);

    expect($project->skills)->toHaveCount(3);
});

test('inactive project factory state works', function () {
    $project = Project::factory()->inactive()->create();

    expect($project->is_active)->toBeFalse();
});

test('published project factory state works', function () {
    $project = Project::factory()->published()->create();

    expect($project->is_active)->toBeTrue()
        ->and($project->published_at)->not->toBeNull();
});

test('project slug is unique', function () {
    Project::factory()->create(['slug' => 'unique-slug']);

    expect(fn () => Project::factory()->create(['slug' => 'unique-slug']))
        ->toThrow(QueryException::class);
});
