<?php

use App\Models\Contact;

test('contact can be created with factory', function () {
    $contact = Contact::factory()->create();

    expect($contact)->toBeInstanceOf(Contact::class)
        ->and($contact->id)->toBeInt()
        ->and($contact->name)->toBeString()
        ->and($contact->email)->toBeString()
        ->and($contact->message)->toBeString();
});

test('contact read factory state works', function () {
    $contact = Contact::factory()->read()->create();

    expect($contact->read_at)->not->toBeNull();
});

test('contact is unread by default', function () {
    $contact = Contact::factory()->create();

    expect($contact->read_at)->toBeNull();
});

test('contact can be mass assigned', function () {
    $contact = Contact::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'message' => 'Hello there!',
    ]);

    expect($contact->name)->toBe('John Doe')
        ->and($contact->email)->toBe('john@example.com')
        ->and($contact->message)->toBe('Hello there!');
});
