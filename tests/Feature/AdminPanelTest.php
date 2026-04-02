<?php

test('admin login page is accessible', function () {
    $this->get('/admin/login')->assertStatus(200);
});

test('admin panel requires authentication', function () {
    $this->get('/admin')->assertRedirect('/admin/login');
});

test('authenticated user can access admin panel', function () {
    $user = createAdmin();

    $this->actingAs($user)
        ->get('/admin')
        ->assertStatus(200);
});

test('admin projects resource is accessible', function () {
    $user = createAdmin();

    $this->actingAs($user)
        ->get('/admin/projects')
        ->assertStatus(200);
});

test('admin skills resource is accessible', function () {
    $user = createAdmin();

    $this->actingAs($user)
        ->get('/admin/skills')
        ->assertStatus(200);
});

test('admin services resource is accessible', function () {
    $user = createAdmin();

    $this->actingAs($user)
        ->get('/admin/services')
        ->assertStatus(200);
});

test('admin experiences resource is accessible', function () {
    $user = createAdmin();

    $this->actingAs($user)
        ->get('/admin/experiences')
        ->assertStatus(200);
});

test('admin contacts resource is accessible', function () {
    $user = createAdmin();

    $this->actingAs($user)
        ->get('/admin/contacts')
        ->assertStatus(200);
});

test('unauthenticated user cannot access admin resources', function () {
    $this->get('/admin/projects')->assertRedirect('/admin/login');
    $this->get('/admin/skills')->assertRedirect('/admin/login');
    $this->get('/admin/services')->assertRedirect('/admin/login');
});
