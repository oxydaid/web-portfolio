<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    // Mengizinkan semua kolom diisi (praktis untuk Filament)
    protected $guarded = []; 

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'date',
    ];

    // Relasi ke Skill
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'project_skill');
    }
}