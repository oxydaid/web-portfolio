<?php

use App\Livewire\HomePage;
use App\Livewire\ProjectDetail;
use App\Livewire\ProjectsPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/project/{slug}', ProjectDetail::class)->name('project.detail');
Route::get('/projects', ProjectsPage::class)->name('projects');
