<?php

use App\Livewire\ContactForm;
use App\Models\Contact;
use Livewire\Livewire;

test('contact form component can be rendered', function () {
    Livewire::test(ContactForm::class)
        ->assertStatus(200);
});

test('contact form validates required fields', function () {
    Livewire::test(ContactForm::class)
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'message']);
});

test('contact form validates name minimum length', function () {
    Livewire::test(ContactForm::class)
        ->set('name', 'ab')
        ->set('email', 'test@example.com')
        ->set('message', 'This is a test message with enough length')
        ->call('submit')
        ->assertHasErrors(['name']);
});

test('contact form validates email format', function () {
    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'not-an-email')
        ->set('message', 'This is a test message with enough length')
        ->call('submit')
        ->assertHasErrors(['email']);
});

test('contact form validates message minimum length', function () {
    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('message', 'Short')
        ->call('submit')
        ->assertHasErrors(['message']);
});

test('contact form submits successfully with valid data', function () {
    Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('message', 'This is a test message with enough characters')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('success', true)
        ->assertSet('name', '')
        ->assertSet('email', '')
        ->assertSet('message', '');

    expect(Contact::count())->toBe(1)
        ->and(Contact::first()->name)->toBe('John Doe')
        ->and(Contact::first()->email)->toBe('john@example.com');
});

test('contact form can be reset after submission', function () {
    $component = Livewire::test(ContactForm::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('message', 'This is a test message with enough characters')
        ->call('submit')
        ->assertSet('success', true);

    $component->call('resetForm')
        ->assertSet('success', false)
        ->assertSet('name', '')
        ->assertSet('email', '')
        ->assertSet('message', '');
});
