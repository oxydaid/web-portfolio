<?php

use App\Models\Project;
use App\Models\Skill;

test('project detail page returns 200 for active project', function () {
    $project = Project::factory()->published()->create();

    $this->get("/project/{$project->slug}")
        ->assertStatus(200)
        ->assertSee($project->title);
});

test('project detail page returns 404 for inactive project', function () {
    $project = Project::factory()->inactive()->create();

    $this->get("/project/{$project->slug}")
        ->assertStatus(404);
});

test('project detail page returns 404 for non-existent slug', function () {
    $this->get('/project/non-existent-slug')
        ->assertStatus(404);
});

test('project detail page shows project skills', function () {
    $project = Project::factory()->published()->create();
    $skill = Skill::factory()->create(['name' => 'Vue.js']);
    $project->skills()->attach($skill);

    $this->get("/project/{$project->slug}")
        ->assertStatus(200)
        ->assertSee('Vue.js');
});

test('project detail page shows project content', function () {
    $project = Project::factory()->published()->create([
        'content' => '<p>This is the project content</p>',
    ]);

    $this->get("/project/{$project->slug}")
        ->assertStatus(200)
        ->assertSee('This is the project content');
});
