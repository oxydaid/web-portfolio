<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Skill;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Title('Projects Archive')]
class ProjectsPage extends Component
{
    use WithPagination;

    // Menyimpan state pencarian di URL (?search=ecommerce)
    #[Url(except: '')]
    public $search = '';

    // Menyimpan state filter tech stack di URL (?tech=laravel)
    #[Url(except: '')]
    public $tech = '';

    // Reset pagination ke halaman 1 setiap kali search/filter berubah
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedTech()
    {
        $this->resetPage();
    }

    // Fungsi untuk memilih tech stack (dipanggil dari view)
    public function setTech($name)
    {
        $this->tech = $name === $this->tech ? '' : $name; // Toggle on/off
    }

    public function render()
    {
        $query = Project::query()
            ->where('is_active', true)
            ->with('skills'); // Eager load skills biar ringan

        // Logic Pencarian
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%');
            });
        }

        // Logic Filter by Skill Name
        if ($this->tech) {
            $query->whereHas('skills', function($q) {
                $q->where('name', $this->tech);
            });
        }

        // Sorting & Pagination
        $projects = $query->orderBy('sort_order')
            ->orderBy('published_at', 'desc')
            ->paginate(9); // 9 item per halaman

        // Ambil list skill yang hanya digunakan di project (untuk menu filter)
        $skills = \Illuminate\Support\Facades\Cache::remember('filter_skills', 3600, function() {
            return Skill::whereHas('projects')->orderBy('name')->get();
        });

        return view('livewire.projects-page', [
            'projects' => $projects,
            'filterSkills' => $skills,
        ])->layout('components.layouts.app', [
            'description' => 'Explore the complete archive of deployed full-stack projects, system modules, and applications.',
            'keywords' => 'projects, applications, portfolio, web developer, frontend, backend, fullstack',
            'ogType' => 'website',
        ]);
    }
}