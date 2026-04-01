<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
class ProjectDetail extends Component
{
    public $slug;
    public Project $project;

    // Menerima parameter slug dari URL
    public function mount($slug)
    {
        $this->slug = $slug;

        // Cari project aktif berdasarkan slug, jika tidak ada -> 404
        $this->project = Project::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    }

    // Mengatur Judul Halaman Browser
    public function title()
    {
        // Hasil di browser: "Judul Project - Project Archives | Nama Website"
        return $this->project->title . ' - Project Archives';
    }

    public function render()
    {
        $description = str($this->project->content)->stripTags()->limit(150);
        $image = $this->project->thumbnail ? Storage::url($this->project->thumbnail) : null;
        $keywords = $this->project->skills->pluck('name')->implode(', ') . ', project, portfolio';

        return view('livewire.project-detail')
            ->title($this->title())
            ->layout('components.layouts.app', [
                'description' => $description,
                'image' => $image,
                'keywords' => $keywords,
                'ogType' => 'article',
                'author' => 'Aghata' // You can adjust this to fetch dynamically, or trust the fallback 
            ]);
    }
}