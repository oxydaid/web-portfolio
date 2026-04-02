<?php

use App\Mail\ContactFormMail;
use App\Models\Contact;

test('contact form mail has correct subject', function () {
    $contact = Contact::factory()->create(['name' => 'Jane Doe']);

    $mail = new ContactFormMail($contact);
    $envelope = $mail->envelope();

    expect($envelope->subject)->toBe('New Contact Form Submission: Jane Doe');
});

test('contact form mail uses correct view', function () {
    $contact = Contact::factory()->create();

    $mail = new ContactFormMail($contact);
    $content = $mail->content();

    expect($content->view)->toBe('emails.contact');
});

test('contact form mail has contact data', function () {
    $contact = Contact::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]);

    $mail = new ContactFormMail($contact);

    expect($mail->contact->name)->toBe('Test User')
        ->and($mail->contact->email)->toBe('test@example.com');
});
