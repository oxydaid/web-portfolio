@inject('settings', 'App\Settings\GeneralSettings')

<div class="pt-32 pb-20 min-h-screen relative overflow-hidden" data-projects-page>
    
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 w-125 h-125 bg-secondary/10 rounded-full blur-[120px] -z-10"></div>
    <div class="absolute bottom-0 left-0 w-125 h-125 bg-primary/10 rounded-full blur-[120px] -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- HEADER & CONTROLS -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12" data-projects-header>
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="h-px w-8 bg-primary"></span>
                    <span class="text-xs font-mono text-primary tracking-widest">SYSTEM_DATABASE</span>
                </div>
                <h1 class="text-4xl md:text-5xl font-display font-bold text-white text-glow">
                    PROJECT <span class="text-transparent bg-clip-text bg-linear-to-r from-primary to-secondary">ARCHIVES</span>
                </h1>
            </div>

            <!-- Search Bar -->
            <div class="w-full md:w-1/3 relative group">
                <div class="absolute -inset-0.5 bg-linear-to-r from-primary to-secondary opacity-30 group-hover:opacity-100 transition duration-500 blur clip-cut-corner"></div>
                <div class="relative bg-dark-900 p-1 clip-cut-corner">
                    <div class="flex items-center bg-dark-950 px-4 py-2">
                        <i class="fa-solid fa-search text-slate-500 mr-3"></i>
                        <input wire:model.live.debounce.300ms="search" 
                            type="text" 
                            class="w-full bg-transparent border-none text-white placeholder-slate-500 focus:ring-0 focus:outline-none font-mono text-sm" 
                            placeholder="SEARCH_QUERY...">
                    </div>
                </div>
            </div>
        </div>

        <!-- FILTER TABS -->
        <div class="mb-12 overflow-x-auto pb-4" data-projects-filters>
            <div class="flex flex-wrap gap-2">
                <!-- Tombol ALL -->
                <button wire:click="$set('tech', '')" 
                    class="px-4 py-2 text-xs font-bold font-display tracking-wider border transition-all clip-cut-corner
                    {{ $tech == '' ? 'bg-primary/75 text-black border-primary shadow-[0_0_10px_rgba(0,240,255,0.4)]' : 'bg-dark-800 text-slate-400 border-white/10 hover:border-primary hover:text-white' }}">
                    /// ALL_SYSTEMS
                </button>

                <!-- Loop Skills -->
                @foreach($filterSkills as $skill)
                <button wire:click="setTech('{{ $skill->name }}')" 
                    class="px-4 py-2 text-xs font-bold font-display tracking-wider border transition-all clip-cut-corner uppercase flex items-center gap-2
                    {{ $tech == $skill->name ? 'bg-secondary/75 text-black border-secondary shadow-[0_0_10px_rgba(189,0,255,0.4)]' : 'bg-dark-800 text-slate-400 border-white/10 hover:border-secondary hover:text-white' }}">
                    @if($skill->icon)
                        <img src="{{ Storage::url($skill->icon) }}" class="w-3 h-3 object-contain opacity-70">
                    @endif
                    {{ $skill->name }}
                </button>
                @endforeach
            </div>
        </div>

        <!-- RESULTS GRID -->
        @if($projects->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12" data-projects-grid>
                @foreach($projects as $project)
                <article class="group relative bg-dark-900 border border-white/10 hover:border-primary/50 transition-all duration-300 flex flex-col h-full overflow-hidden" data-project-card>
                    <!-- Image -->
                     <a href="{{ route('project.detail', $project->slug) }}" class="block relative h-48 overflow-hidden bg-black">
                        <div class="absolute inset-0 bg-primary/20 opacity-0 group-hover:opacity-100 transition-opacity z-10 mix-blend-overlay"></div>
                        @if($project->thumbnail)
                            <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 opacity-80 group-hover:opacity-100">
                        @else
                             <div class="w-full h-full bg-slate-800 flex items-center justify-center">No Thumbnail</div>
                        @endif
                        <!-- Corner Cut Visual -->
                        <div class="absolute top-0 right-0 w-8 h-8 bg-dark-900 z-20" style="clip-path: polygon(0 0, 100% 0, 100% 100%);"></div>
                    </a>
                    
                    <div class="p-6 flex-1 flex flex-col relative">
                        <!-- Skills -->
                        <div class="flex gap-2 mb-4 flex-wrap">
                            @foreach($project->skills->take(3) as $skill)
                                <span class="text-[10px] font-bold font-display tracking-wider px-2 py-1 bg-white/5 text-slate-300 border border-white/10 uppercase">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                        </div>
                        
                        <a href="{{ route('project.detail', $project->slug) }}">
                            <h3 class="text-xl font-display font-bold text-white mb-2 group-hover:text-primary transition-colors uppercase">{{ $project->title }}</h3>
                        </a>
                        
                        <div class="text-slate-400 text-sm mb-6 line-clamp-3">
                            {{ strip_tags($project->content) }}
                        </div>
                        
                        <div class="mt-auto flex items-center gap-4 pt-4 border-t border-white/5">
                            @if($project->demo_url)
                            <a href="{{ $project->demo_url }}" target="_blank" class="text-white hover:text-primary text-xs font-bold font-display tracking-widest flex items-center gap-1">
                                <i class="fa-solid fa-globe w-3 h-3"></i> LIVE_DEMO
                            </a>
                            @endif
                            <a href="{{ route('project.detail', $project->slug) }}" class="text-slate-400 hover:text-white text-xs font-bold font-display tracking-widest flex items-center gap-1 ml-auto">
                                <i class="fa-solid fa-arrow-right w-3 h-3"></i> DETAILS
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- PAGINATION -->
            <div class="mt-8">
                {{ $projects->links(data: ['scrollTo' => false]) }}
            </div>

        @else
            <!-- EMPTY STATE -->
            <div class="text-center py-20 border border-dashed border-white/10 rounded-lg bg-white/5" data-projects-empty>
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-dark-800 mb-4">
                    <i class="fa-solid fa-database text-slate-500 text-2xl"></i>
                </div>
                <h3 class="text-xl font-display font-bold text-white mb-2">NO DATA FOUND</h3>
                <p class="text-slate-400 font-mono text-sm">Query returned 0 results. Try adjusting filters.</p>
                <button wire:click="$set('search', '')" class="mt-6 text-primary hover:text-white text-xs font-bold tracking-widest border-b border-primary uppercase">
                    CLEAR_SEARCH_PARAMS
                </button>
            </div>
        @endif

    </div>
</div>