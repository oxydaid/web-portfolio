<?php

namespace App\Livewire;

use App\Models\Experience;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home')] // Mengatur title browser otomatis
class HomePage extends Component
{
    public function render()
    {
        return view('livewire.home-page', [
            // Mengambil 4 Skill utama untuk ditampilkan di Hero
            'skills' => Skill::take(8)->get(), 
            
            // Mengambil Service yang aktif
            'services' => Service::where('is_active', true)
                ->orderBy('sort_order')
                ->get(),

            // Mengambil Project, diurutkan terbaru, max 6 item
            'projects' => Project::with('skills') // Eager load skill agar ringan
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('published_at', 'desc')
                ->take(6)
                ->get(),
                
            'totalProjects' => Project::where('is_active', true)->count(),

            // Mengambil Experience
            'experiences' => Experience::orderBy('start_date', 'desc')->get(),
        ]);
    }
}