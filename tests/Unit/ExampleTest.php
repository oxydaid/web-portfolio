<?php

use App\Models\User;
use Filament\Panel;

test('user can be created with factory', function () {
    $user = User::factory()->create();

    expect($user)->toBeInstanceOf(User::class)
        ->and($user->id)->toBeInt()
        ->and($user->name)->toBeString()
        ->and($user->email)->toBeString();
});

test('user password is hashed', function () {
    $user = User::factory()->create(['password' => 'password123']);

    expect($user->password)->not->toBe('password123')
        ->and(password_verify('password123', $user->password))->toBeTrue();
});

test('user hides password and remember token', function () {
    $user = User::factory()->create();

    $serialized = $user->toArray();

    expect($serialized)->not->toHaveKey('password')
        ->and($serialized)->not->toHaveKey('remember_token');
});

test('user can access filament panel', function () {
    $user = User::factory()->create();

    // FilamentUser contract requires canAccessPanel
    expect($user->canAccessPanel(new Panel))->toBeTrue();
});

test('user fillable attributes are correct', function () {
    $user = new User;

    expect($user->getFillable())->toContain('name', 'email', 'password');
});
