<?php

use App\Models\Project;
use App\Models\Skill;

test('projects page returns successful response', function () {
    $this->get('/projects')->assertStatus(200);
});

test('projects page shows active projects', function () {
    Project::factory()->published()->create(['title' => 'Visible Project']);
    Project::factory()->inactive()->create(['title' => 'Hidden Project']);

    $this->get('/projects')
        ->assertStatus(200)
        ->assertSee('Visible Project')
        ->assertDontSee('Hidden Project');
});

test('projects page supports search', function () {
    Project::factory()->published()->create(['title' => 'Laravel App']);
    Project::factory()->published()->create(['title' => 'React Frontend']);

    $this->get('/projects?search=Laravel')
        ->assertStatus(200)
        ->assertSee('Laravel App');
});

test('projects page supports tech filter', function () {
    $skill = Skill::factory()->create(['name' => 'Docker']);
    $projectWithSkill = Project::factory()->published()->create(['title' => 'Docker Project']);
    $projectWithSkill->skills()->attach($skill);

    Project::factory()->published()->create(['title' => 'Other Project']);

    cache()->forget('filter_skills');

    $this->get('/projects?tech=Docker')
        ->assertStatus(200)
        ->assertSee('Docker Project');
});

test('projects page paginates results', function () {
    Project::factory()->count(15)->published()->create();

    $this->get('/projects')
        ->assertStatus(200);
});
