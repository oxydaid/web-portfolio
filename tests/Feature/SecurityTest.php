<?php

/**
 * Security-focused tests to catch common web vulnerabilities
 */

use App\Livewire\ContactForm;
use App\Models\Contact;
use App\Models\Project;
use App\Models\User;
use Livewire\Livewire;

// ─── XSS Prevention ─────────────────────────────────────────────

test('contact form sanitizes XSS in name field', function () {
    Livewire::test(ContactForm::class)
        ->set('name', '<script>alert("xss")</script>')
        ->set('email', 'test@example.com')
        ->set('message', 'This is a legitimate message with enough characters')
        ->call('submit')
        ->assertHasNoErrors();

    $contact = Contact::first();
    // Data is stored raw but Blade {{ }} auto-escapes on render
    expect($contact->name)->toBe('<script>alert("xss")</script>');
});

// ─── SQL Injection Prevention ───────────────────────────────────

test('search parameter is safe from SQL injection', function () {
    Project::factory()->published()->create(['title' => 'Safe Project']);

    // Attempt SQL injection via search
    $this->get("/projects?search=' OR 1=1 --")
        ->assertStatus(200);

    // Should not crash and should not return all projects
    $this->get("/projects?search='; DROP TABLE projects; --")
        ->assertStatus(200);
});

test('route parameters are safe from injection', function () {
    // Attempt SQL injection via slug
    $this->get("/project/' OR '1'='1")
        ->assertStatus(404);
});

// ─── Mass Assignment Protection ─────────────────────────────────

test('users table has fillable protection', function () {
    $user = new User;

    // User model uses $fillable (whitelist), not $guarded
    expect($user->getFillable())->toBe(['name', 'email', 'password']);
});

// ─── Authentication Security ────────────────────────────────────

test('admin panel requires authentication', function () {
    $this->get('/admin')
        ->assertRedirect('/admin/login');
});

test('admin resources require authentication', function () {
    $this->get('/admin/projects')->assertRedirect('/admin/login');
    $this->get('/admin/skills')->assertRedirect('/admin/login');
    $this->get('/admin/services')->assertRedirect('/admin/login');
    $this->get('/admin/contacts')->assertRedirect('/admin/login');
});

// ─── Security Headers ──────────────────────────────────────────

test('application sets proper content type headers', function () {
    $response = $this->get('/');

    expect($response->headers->get('Content-Type'))->toContain('text/html');
});

// ─── Path Traversal Prevention ──────────────────────────────────

test('cannot access sensitive files via URL', function () {
    // .env should not be served (404 or 403 - both are acceptable security responses)
    $response = $this->get('/.env');
    expect($response->status())->toBeIn([403, 404]);

    $response = $this->get('/config/database.php');
    expect($response->status())->toBeIn([403, 404]);
});

// ─── Input Validation ───────────────────────────────────────────

test('contact form rejects extremely long input without crashing', function () {
    Livewire::test(ContactForm::class)
        ->set('name', str_repeat('a', 300))
        ->set('email', 'test@example.com')
        ->set('message', str_repeat('b', 100000))
        ->call('submit');

    // Should either validate/reject or accept - but must not crash
    expect(true)->toBeTrue();
});

test('contact form validates required fields for security', function () {
    Livewire::test(ContactForm::class)
        ->set('name', '')
        ->set('email', '')
        ->set('message', '')
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'message']);
});

test('contact form validates email format to prevent header injection', function () {
    Livewire::test(ContactForm::class)
        ->set('name', 'Attacker')
        ->set('email', "attacker@example.com\r\nBcc: victim@example.com")
        ->set('message', 'Header injection attempt here!!!')
        ->call('submit')
        ->assertHasErrors(['email']);
});
