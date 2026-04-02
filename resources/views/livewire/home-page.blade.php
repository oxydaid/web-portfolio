@inject('settings', 'App\Settings\GeneralSettings')

<div data-home-page>
    <!-- HERO SECTION -->
    <section id="home" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden z-10" data-home-hero>
        <!-- Abstract Sci-Fi Blobs -->
        <div class="absolute top-20 right-0 w-125 h-125 bg-primary/10 rounded-full blur-[100px] animate-pulse-slow"></div>
        <div class="absolute bottom-0 left-0 w-125 h-125 bg-secondary/10 rounded-full blur-[100px]"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                
                <!-- Text Content -->
                <div class="text-center lg:text-left" data-home-hero-text>
                    <!-- Status Badge -->
                    <div class="inline-flex items-center gap-3 px-4 py-1.5 border border-primary/30 bg-primary/5 mb-8 clip-cut-corner-reverse">
                        <span class="relative flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-primary"></span>
                        </span>
                        <span class="text-primary font-display font-bold tracking-[0.2em] text-sm">SYSTEM STATUS: ONLINE</span>
                    </div>

                    <h1 class="text-5xl lg:text-7xl font-display font-bold text-white leading-none mb-6">
                        {{ explode(' ', $settings->dev_title)[0] ?? 'FULLSTACK' }} <br>
                        <span class="text-transparent bg-clip-text bg-linear-to-r from-primary via-white to-secondary uppercase"
                              style="filter: drop-shadow(0 0 10px var(--primary)) drop-shadow(0 0 20px var(--secondary));">
                            {{ isset(explode(' ', $settings->dev_title)[1]) ? substr(strstr($settings->dev_title, " "), 1) : 'DEVELOPER' }}
                        </span>
                    </h1>
                    
                    <div class="text-lg text-slate-400 mb-10 max-w-2xl mx-auto lg:mx-0 font-light lg:border-l-2 lg:border-primary/30 lg:pl-6 prose prose-invert">
                        {!! $settings->dev_bio !!}
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-5 justify-center lg:justify-start">
                        <a href="#projects" class="group relative px-8 py-3.5 bg-transparent overflow-hidden">
                            <div class="absolute inset-0 w-full h-full bg-primary/10 border border-primary clip-cut-corner transition-all group-hover:bg-primary/20"></div>
                            <span class="relative text-primary font-display font-bold tracking-widest text-lg group-hover:text-white transition-colors">VIEW_PROJECTS</span>
                        </a>
                        
                        <!-- Github Link Dynamic -->
                         @foreach($settings->social_links ?? [] as $social)
                            @if($social['platform'] === 'github')
                            <a href="{{ $social['url'] }}" target="_blank" class="group relative px-8 py-3.5 flex items-center justify-center gap-2">
                                <div class="absolute inset-0 w-full h-full border border-white/20 clip-cut-corner bg-dark-800 transition-all group-hover:border-white/50"></div>
                                <i class="fa-brands fa-github w-5 h-5 relative z-10 text-white"></i>
                                <span class="relative z-10 text-white font-display font-bold tracking-widest">GITHUB_REPO</span>
                            </a>
                            @endif
                        @endforeach
                    </div>
                    
                    <!-- Tech Stack HUD -->
                    <div class="mt-16">
                        <p class="text-xs font-bold text-primary font-display tracking-[0.3em] mb-4">MAINFRAME STACK</p>
                        <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                            @foreach($skills as $skill)
                                <div class="px-4 py-2 border border-white/10 bg-dark-900/50 flex items-center gap-2 hover:border-primary/50 transition-colors" data-home-tech-item>
                                    @if($skill->icon)
                                        <img src="{{ Storage::url($skill->icon) }}" class="w-4 h-4 object-contain" alt="{{ $skill->name }}">
                                    @else
                                        <i class="fa-solid fa-microchip text-primary w-4 h-4"></i>
                                    @endif
                                    <span class="text-sm font-bold font-display uppercase">{{ $skill->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Hero Visual -->
                <div class="relative lg:h-150 flex items-center justify-center z-10 mt-12 lg:mt-0" data-home-hero-visual>
                    <div class="relative w-full max-w-md aspect-4/5">
                        <!-- Holographic Borders -->
                        <div class="absolute inset-0 border-2 border-primary/30 clip-cut-corner"></div>
                        <div class="absolute inset-2 border border-primary/10 clip-cut-corner"></div>
                        
                        <!-- Corner Decorations -->
                        <div class="absolute -top-1 -left-1 w-8 h-8 border-t-2 border-l-2 border-primary"></div>
                        <div class="absolute -bottom-1 -right-1 w-8 h-8 border-b-2 border-r-2 border-primary"></div>
                        
                        <!-- Image -->
                        <div class="absolute inset-4 overflow-hidden clip-cut-corner bg-dark-800">
                             <div class="absolute inset-0 bg-[linear-linear(transparent_50%,rgba(0,240,255,0.05)_50%)] bg-size-[100%_4px] pointer-events-none z-20"></div>
                            
                            @if($settings->dev_avatar)
                                <img src="{{ Storage::url($settings->dev_avatar) }}" alt="Developer" class="w-full h-full object-cover opacity-80 hover:opacity-100 transition-opacity grayscale hover:grayscale-0 duration-500">
                            @else
                                <div class="w-full h-full bg-slate-800 flex items-center justify-center text-slate-600">No Image</div>
                            @endif
                        </div>

                        <div class="absolute -bottom-12 left-1/2 -translate-x-1/2 lg:translate-x-0 lg:left-auto lg:-right-8 lg:bottom-20 w-max z-30">
                            <div class="bg-dark-900/90 border border-secondary/50 p-4 backdrop-blur-md clip-cut-corner-reverse shadow-[0_0_20px_rgba(189,0,255,0.2)] animate-bounce duration-4000">
                                <div class="flex items-center gap-3">
                                    <div class="text-secondary">
                                        <i class="fa-solid fa-trophy w-6 h-6"></i>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-display font-bold text-white">LVL. {{ $totalProjects  }}+</div>
                                        <div class="text-xs text-secondary tracking-wider font-display">PROJECTS DEPLOYED</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES SECTION -->
    <section id="services" class="py-24 bg-dark-900/50 relative border-y border-white/5" data-home-services>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-16" data-home-services-header>
                <div>
                    <h2 class="text-4xl font-display font-bold text-white">SYSTEM <span class="text-primary">CAPABILITIES</span></h2>
                    <div class="h-1 w-20 bg-primary mt-2"></div>
                </div>
                <div class="text-right hidden md:block">
                    <p class="text-xs font-mono text-primary/50">/// SERVICES_MODULE_LOADED</p>
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @foreach($services as $service)
                <div class="group relative p-1" data-home-service-card>
                    <div class="absolute inset-0 bg-linear-to-br from-primary via-transparent to-secondary opacity-20 group-hover:opacity-100 transition-opacity duration-500 clip-cut-corner"></div>
                    
                    <div class="relative h-full bg-dark-950 p-8 clip-cut-corner border border-white/10 group-hover:border-transparent transition-all">
                        <div class="w-12 h-12 bg-primary/10 border border-primary/30 flex items-center justify-center text-primary mb-6 group-hover:bg-primary group-hover:text-black transition-colors leading-none">
                            @if($service->icon)
                                <i class="{{ $service->icon }} text-lg"></i>
                            @else
                                <i class="fa-solid fa-layer-group text-lg"></i>
                            @endif
                        </div>
                        <h3 class="text-2xl font-display font-bold text-white mb-3 uppercase">{{ $service->title }}</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">{{ $service->short_description }}</p>
                        @if($service->price_start_from)
                            <div class="mt-4 pt-4 border-t border-white/5 text-sm font-mono text-primary">
                                START FROM: IDR {{ number_format($service->price_start_from) }}
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- EXPERIENCE SECTION -->
    <section id="experience" class="py-24 relative z-10" data-home-experience>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-home-experience-header>
                 <h2 class="text-4xl font-display font-bold text-white">CAREER <span class="text-secondary">LOGS</span></h2>
            </div>

            <div class="relative border-l-2 border-white/10 ml-4 md:ml-0 space-y-12">
                @foreach($experiences as $exp)
                <div class="relative pl-8 md:pl-16 group" data-home-exp-item>
                    <!-- Dot Indicator -->
                    <div class="absolute -left-27.5 top-1 w-6 h-6 bg-dark-950 border-2 {{ $loop->first ? 'border-primary' : 'border-secondary' }} flex items-center justify-center group-hover:scale-125 transition-transform">
                        <div class="w-2 h-2 {{ $loop->first ? 'bg-primary' : 'bg-secondary' }}"></div>
                    </div>
                    
                    <div class="border border-white/10 bg-dark-900/40 p-6 clip-cut-corner-reverse hover:border-primary/50 transition-colors">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-2">
                            <h3 class="text-xl font-display font-bold text-white uppercase">{{ $exp->role }}</h3>
                            <span class="text-xs font-bold font-display {{ $loop->first ? 'text-primary border-primary/30 bg-primary/5' : 'text-slate-400 border-white/10 bg-white/5' }} border px-3 py-1">
                                {{ $exp->start_date->format('Y') }} - {{ $exp->is_current ? 'PRESENT' : $exp->end_date->format('Y') }}
                            </span>
                        </div>
                        <div class="text-md text-slate-300 mb-4 font-mono">@ {{ strtoupper($exp->company_name) }}</div>
                        <p class="text-slate-400 text-sm whitespace-pre-line">{{ $exp->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- PROJECTS SECTION -->
    <section id="projects" class="py-24 bg-dark-800/20 border-t border-white/5" data-home-projects>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-4" data-home-projects-header>
                <div>
                    <h2 class="text-4xl font-display font-bold text-white mb-2">DEPLOYED <span class="text-transparent bg-clip-text bg-linear-to-r from-primary to-secondary">PROJECTS</span></h2>
                    <p class="text-slate-400 font-mono text-sm">/// SELECT_FILE_TO_VIEW</p>
                </div>
                
                <!-- TOMBOL NAVIGASI KE ARSIP PROJECT (DESKTOP) -->
                <a href="{{ route('projects') }}" class="group hidden md:flex items-center gap-2 text-primary hover:text-white transition-colors">
                    <span class="font-display font-bold tracking-widest border-b border-primary group-hover:border-white pb-1">VIEW_ALL_ARCHIVES</span>
                    <i class="fa-solid fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $project)
                <article class="group relative bg-dark-900 border border-white/10 hover:border-primary/50 transition-all duration-300 flex flex-col h-full overflow-hidden" data-home-project-card>
                    <!-- Image -->
                     <a href="{{ route('project.detail', $project->slug) }}">
                         <div class="relative h-48 overflow-hidden bg-black">
                             <div class="absolute inset-0 bg-primary/20 opacity-0 group-hover:opacity-100 transition-opacity z-10 mix-blend-overlay"></div>
                             @if($project->thumbnail)
                                 <img src="{{ Storage::url($project->thumbnail) }}" alt="{{ $project->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 opacity-80 group-hover:opacity-100">
                             @else
                                  <div class="w-full h-full bg-slate-800 flex items-center justify-center">No Thumbnail</div>
                             @endif
                             <div class="absolute top-0 right-0 w-8 h-8 bg-dark-900 z-20" style="clip-path: polygon(0 0, 100% 0, 100% 100%);"></div>
                         </div>
                     </a>
                    
                    <div class="p-6 flex-1 flex flex-col relative">
                        <!-- Skills -->
                        <div class="flex gap-2 mb-4 flex-wrap">
                            @foreach($project->skills->take(3) as $skill)
                                <span class="text-[10px] font-bold font-display tracking-wider px-2 py-1 bg-white/5 text-slate-300 border border-white/10 uppercase">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                            
                            {{-- Logic untuk menampilkan sisa jumlah skill --}}
                            @if($project->skills->count() > 3)
                                <span class="text-[10px] font-bold font-display tracking-wider px-2 py-1 bg-primary/10 text-primary border border-primary/20 uppercase">
                                    +{{ $project->skills->count() - 3 }}
                                </span>
                            @endif
                        </div>
                        
                        <a href="{{ route('project.detail', $project->slug) }}" class="text-xl font-display font-bold text-white mb-2 group-hover:text-primary transition-colors uppercase">{{ $project->title }}</a>
                        
                        <div class="text-slate-400 text-sm mb-6 line-clamp-3">
                            {{ strip_tags($project->content) }}
                        </div>
                        
                        <div class="mt-auto flex items-center gap-4 pt-4 border-t border-white/5">
                            @if($project->demo_url)
                            <a href="{{ $project->demo_url }}" target="_blank" class="text-white hover:text-primary text-xs font-bold font-display tracking-widest flex items-center gap-1">
                                <i class="fa-solid fa-globe" class="w-3 h-3"></i> LIVE_DEMO
                            </a>
                            @endif

                            @if($project->github_url)
                            <a href="{{ $project->github_url }}" target="_blank" class="text-slate-400 hover:text-white text-xs font-bold font-display tracking-widest flex items-center gap-1 ml-auto">
                                <i class="fa-brands fa-github" class="w-3 h-3"></i> SOURCE
                            </a>
                            @endif
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- TOMBOL NAVIGASI KE ARSIP PROJECT (MOBILE) -->
            <div class="mt-8 flex md:hidden justify-center">
                <a href="{{ route('projects') }}" class="group flex items-center gap-2 text-primary hover:text-white transition-colors">
                    <span class="font-display font-bold tracking-widest border-b border-primary group-hover:border-white pb-1">VIEW_ALL_ARCHIVES</span>
                    <i class="fa-solid fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- CONTACT SECTION -->
    <section id="contact" class="py-24 relative overflow-hidden" data-home-contact>
        <div class="absolute inset-0 bg-linear-to-t from-primary/10 to-transparent pointer-events-none"></div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10" data-home-contact-content>
            <h2 class="text-4xl font-display font-bold text-white mb-6">INITIALIZE <span class="text-primary">COLLABORATION?</span></h2>
            <p class="text-xl text-slate-400 mb-12">Ready to deploy your next big idea. Transmission channels are open.</p>
            
            <!-- INSERT CONTACT FORM HERE -->
            <livewire:contact-form />

            <!-- Social Icons -->
             <div class="flex justify-center gap-6 mt-16 pt-8 border-t border-white/5">
                @foreach($settings->social_links ?? [] as $social)
                    <a href="{{ $social['url'] }}" target="_blank" class="text-slate-500 hover:text-primary transition-colors transform hover:scale-110" data-home-social-link>
                         @if($social['platform'] == 'github') <i class="fa-brands fa-github w-6 h-6"></i>
                        @elseif($social['platform'] == 'linkedin') <i class="fa-brands fa-linkedin w-6 h-6"></i>
                        @elseif($social['platform'] == 'instagram') <i class="fa-brands fa-instagram w-6 h-6"></i>
                        @elseif($social['platform'] == 'twitter') <i class="fa-brands fa-twitter w-6 h-6"></i>
                        @elseif($social['platform'] == 'whatsapp') <i class="fa-brands fa-whatsapp w-6 h-6"></i>
                        @elseif($social['platform'] == 'discord') <i class="fa-brands fa-discord w-6 h-6"></i>
                        @elseif($social['platform'] == 'tiktok') <i class="fa-brands fa-tiktok w-6 h-6"></i>
                        @else <i class="fa-solid fa-link w-6 h-6"></i>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</div>