<?php

use App\Models\Experience;
use Illuminate\Support\Carbon;

test('experience can be created with factory', function () {
    $experience = Experience::factory()->create();

    expect($experience)->toBeInstanceOf(Experience::class)
        ->and($experience->id)->toBeInt()
        ->and($experience->company_name)->toBeString()
        ->and($experience->role)->toBeString();
});

test('experience has correct casts', function () {
    $experience = Experience::factory()->create([
        'start_date' => '2024-01-01',
        'end_date' => '2025-01-01',
        'is_current' => false,
    ]);

    expect($experience->start_date)->toBeInstanceOf(Carbon::class)
        ->and($experience->end_date)->toBeInstanceOf(Carbon::class)
        ->and($experience->is_current)->toBeBool();
});

test('current experience factory state works', function () {
    $experience = Experience::factory()->current()->create();

    expect($experience->is_current)->toBeTrue()
        ->and($experience->end_date)->toBeNull();
});

test('experience type defaults to work', function () {
    $experience = Experience::factory()->create();

    expect($experience->type)->toBeIn(['work', 'education']);
});
