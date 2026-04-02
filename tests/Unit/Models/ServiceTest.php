<?php

use App\Models\Service;

test('service can be created with factory', function () {
    $service = Service::factory()->create();

    expect($service)->toBeInstanceOf(Service::class)
        ->and($service->id)->toBeInt()
        ->and($service->title)->toBeString();
});

test('service has correct casts', function () {
    $service = Service::factory()->create(['is_active' => 1]);

    expect($service->is_active)->toBeBool()
        ->and($service->is_active)->toBeTrue();
});

test('inactive service factory state works', function () {
    $service = Service::factory()->inactive()->create();

    expect($service->is_active)->toBeFalse();
});

test('service has all expected attributes', function () {
    $service = Service::factory()->create([
        'title' => 'Web Development',
        'short_description' => 'Building modern web applications',
        'sort_order' => 1,
    ]);

    expect($service->title)->toBe('Web Development')
        ->and($service->short_description)->toBe('Building modern web applications')
        ->and($service->sort_order)->toBe(1);
});
