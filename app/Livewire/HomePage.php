<?php

namespace App\Livewire;

use App\Models\Experience;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home')] // Mengatur title browser otomatis
class HomePage extends Component
{
    public function render()
    {
        return view('livewire.home-page', [
            // Mengambil 4 Skill utama untuk ditampilkan di Hero (dicache 1 jam)
            'skills' => Cache::remember('home_skills', 3600, fn () => Skill::take(8)->get()), 
            
            // Mengambil Service yang aktif (dicache 1 jam)
            'services' => Cache::remember('home_services', 3600, fn () => Service::where('is_active', true)
                ->orderBy('sort_order')
                ->get()),

            // Mengambil Project, diurutkan terbaru, max 6 item (dicache 1 jam)
            'projects' => Cache::remember('home_projects', 3600, fn () => Project::with('skills') // Eager load skill agar ringan
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('published_at', 'desc')
                ->take(6)
                ->get()),
                
            'totalProjects' => Cache::remember('home_total_projects', 3600, fn () => Project::where('is_active', true)->count()),

            // Mengambil Experience (dicache 1 jam)
            'experiences' => Cache::remember('home_experiences', 3600, fn () => Experience::orderBy('start_date', 'desc')->get()),
        ]);
    }
}