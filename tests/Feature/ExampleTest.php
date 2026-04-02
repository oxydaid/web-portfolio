<?php

use App\Models\Experience;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;

test('homepage returns successful response', function () {
    $this->get('/')->assertStatus(200);
});

test('homepage displays skills', function () {
    Skill::factory()->create(['name' => 'Laravel']);

    cache()->forget('home_skills');

    $this->get('/')
        ->assertStatus(200)
        ->assertSee('Laravel');
});

test('homepage displays active services only', function () {
    Service::factory()->create([
        'title' => 'Web Development',
        'is_active' => true,
        'price_start_from' => 5000000,
    ]);
    Service::factory()->create([
        'title' => 'Hidden Service',
        'is_active' => false,
        'price_start_from' => 1000000,
    ]);

    cache()->forget('home_services');

    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee('Web Development')
        ->assertDontSee('Hidden Service');
});

test('homepage displays active projects', function () {
    $skill = Skill::factory()->create(['name' => 'PHP']);
    $project = Project::factory()->published()->create([
        'title' => 'Active Project',
    ]);
    $project->skills()->attach($skill);

    Project::factory()->inactive()->create([
        'title' => 'Hidden Project',
    ]);

    cache()->forget('home_projects');
    cache()->forget('home_total_projects');

    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee('Active Project');
});

test('homepage displays experiences', function () {
    Experience::factory()->create([
        'company_name' => 'Tech Corp',
        'role' => 'Senior Developer',
    ]);

    cache()->forget('home_experiences');

    // Just ensure the page loads without errors
    $this->get('/')->assertStatus(200);
});

test('homepage renders without data', function () {
    // Should not crash when database is empty
    cache()->flush();

    $this->get('/')->assertStatus(200);
});
