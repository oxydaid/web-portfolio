@inject('settings', 'App\Settings\GeneralSettings')

<div class="pt-24 sm:pt-32 pb-20 min-h-screen relative overflow-hidden">
    
    <!-- Background Decor -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-125 bg-primary/5 blur-[120px] -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- BREADCRUMB -->
        <div class="mb-8 flex flex-wrap items-center gap-2 text-xs sm:text-sm font-mono text-primary/60">
            <a href="{{ route('home') }}" class="hover:text-primary transition-colors">/// SYSTEM</a>
            <span>></span>
            <a href="{{ route('home') }}#projects" class="hover:text-primary transition-colors">ARCHIVES</a>
            <span>></span>
            <span class="text-white break-all">FILE: {{ strtoupper($project->slug) }}</span>
        </div>

        <!-- HEADER SECTION -->
        <header class="mb-8 sm:mb-12">
            <h1 class="text-3xl sm:text-4xl md:text-6xl font-display font-bold text-white mb-6 uppercase text-glow leading-tight">
                {{ $project->title }}
            </h1>
            
            <!-- Big Thumbnail -->
            <div class="relative w-full aspect-video rounded-lg overflow-hidden border border-white/10 group">
                <div class="absolute inset-0 bg-primary/10 mix-blend-overlay z-10"></div>
                <div class="absolute inset-0 bg-[linear-gradient(transparent_50%,rgba(0,0,0,0.5)_50%)] bg-size-[100%_4px] pointer-events-none z-20 opacity-30"></div>
                
                @if($project->thumbnail)
                    <img src="{{ Storage::url($project->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $project->title }}">
                @else
                    <div class="w-full h-full bg-dark-900 flex items-center justify-center text-slate-500">NO VISUAL DATA</div>
                @endif
                
                <div class="absolute top-0 left-0 w-8 h-8 sm:w-16 sm:h-16 border-t-2 sm:border-t-4 border-l-2 sm:border-l-4 border-primary z-30"></div>
                <div class="absolute bottom-0 right-0 w-8 h-8 sm:w-16 sm:h-16 border-b-2 sm:border-b-4 border-r-2 sm:border-r-4 border-secondary z-30"></div>
            </div>
        </header>

        <!-- CONTENT GRID -->
        <div class="grid lg:grid-cols-3 gap-8 sm:gap-12">
            
            <!-- MAIN CONTENT (Left) -->
            <div class="lg:col-span-2">
                <div class="bg-dark-900/50 border border-white/10 p-5 sm:p-8 clip-cut-corner relative">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 sm:gap-0 mb-6 sm:mb-8 border-b border-white/5 pb-4">
                        <h2 class="text-lg sm:text-xl font-display font-bold text-primary tracking-widest">>> MISSION_REPORT_LOG</h2>
                        <span class="text-[10px] sm:text-xs font-mono text-slate-500">ENCRYPTED_DATA</span>
                    </div>

                    <div class="prose prose-invert prose-sm sm:prose-lg max-w-none text-slate-300">
                        {!! $project->content !!}
                    </div>
                </div>
                <!-- Tombol Archive dipindahkan dari sini agar urutannya benar di Mobile -->
            </div>

            <!-- SIDEBAR INFO (Right) -->
            <aside class="space-y-6 sm:space-y-8">
                
                <!-- Project Data Card -->
                <div class="bg-dark-900 border border-white/10 p-5 sm:p-6">
                    <h3 class="text-sm font-display font-bold text-white mb-6 border-l-2 border-secondary pl-3">
                        METADATA
                    </h3>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center border-b border-white/5 pb-2">
                            <span class="text-xs font-mono text-slate-500">DEPLOYMENT_DATE</span>
                            <span class="text-sm font-bold text-white">{{ $project->published_at ? $project->published_at->format('d M Y') : 'CLASSIFIED' }}</span>
                        </div>
                        
                        <div class="pt-2">
                            <span class="text-xs font-mono text-slate-500 block mb-3">TECH_STACK_USED</span>
                            <div class="flex flex-wrap gap-2">
                                @foreach($project->skills as $skill)
                                    <span class="px-2 py-1 bg-white/5 border border-white/10 text-[10px] sm:text-xs text-white font-bold font-display tracking-wide flex items-center gap-1.5">
                                        @if($skill->icon)
                                            <img src="{{ Storage::url($skill->icon) }}" class="w-3 h-3 sm:w-4 sm:h-4 object-contain" alt="{{ $skill->name }}">
                                        @else
                                            <i class="fa-solid fa-microchip text-primary"></i>
                                        @endif
                                        {{ strtoupper($skill->name) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions Buttons -->
                <div class="space-y-4">
                    @if($project->demo_url)
                    <a href="{{ $project->demo_url }}" target="_blank" class="block w-full text-center py-3 sm:py-4 bg-primary hover:bg-cyan-400 text-black font-display font-bold tracking-widest clip-cut-corner shadow-[0_0_15px_rgba(0,240,255,0.3)] transition-all hover:-translate-y-1 text-sm sm:text-base">
                        LAUNCH_DEMO_PREVIEW
                    </a>
                    @endif

                    @if($project->github_url)
                    <a href="{{ $project->github_url }}" target="_blank" class="block w-full text-center py-3 sm:py-4 bg-dark-800 hover:bg-white/10 border border-white/20 text-white font-display font-bold tracking-widest clip-cut-corner transition-all text-sm sm:text-base">
                        ACCESS_SOURCE_CODE
                    </a>
                    @endif
                </div>

            </aside>

            <!-- Back Button Moved Here (Outside columns, treated as new row item) -->
            <!-- lg:col-span-2 ensures it stays on the left side on desktop -->
            <div class="lg:col-span-2">
                <a href="{{ route('home') }}#projects" class="inline-flex items-center gap-2 text-slate-400 hover:text-white transition-colors">
                    <i class="fa-solid fa-arrow-left"></i> RETURN TO ARCHIVES
                </a>
            </div>

        </div>
    </div>
</div>