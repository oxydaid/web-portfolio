@inject('settings', 'App\Settings\GeneralSettings')

{{-- 
    Logika Alpine.js Fix:
    1. init(): Menangani scroll saat load jika ada hash, dan auto-active menu 'Projects' jika di halaman detail.
    2. scrollTo(): Melakukan scroll halus tanpa menambah hash ke URL.
    3. @click handlers: Diperbaiki menggunakan if(isHomePage) untuk mencegah reload hanya saat di Home.
--}}
<nav 
    x-data="{ 
        mobileMenuOpen: false,
        activeSection: 'home', 
        isHomePage: {{ request()->routeIs('home') ? 'true' : 'false' }},
        init() {
            // 1. Force active 'projects' jika sedang di halaman projects (bukan home)
            @if(request()->routeIs('project*'))
                this.activeSection = 'projects';
                return; 
            @endif

            // 2. Handle Hash saat Load (misal redirect dari halaman project ke /#services)
            if (window.location.hash) {
                const id = window.location.hash.substring(1);
                this.activeSection = id;
                
                // Tunggu render, scroll, lalu bersihkan URL
                setTimeout(() => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth' });
                    }
                    history.replaceState(null, null, window.location.pathname);
                }, 100);
            }

            // 3. Scroll Spy (Intersection Observer) hanya untuk Home Page
            if (this.isHomePage) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            this.activeSection = entry.target.id;
                        }
                    });
                }, { 
                    rootMargin: '-20% 0px -50% 0px', 
                    threshold: 0.1
                });

                ['home', 'services', 'projects', 'experience'].forEach(id => {
                    const el = document.getElementById(id);
                    if (el) observer.observe(el);
                });
            }
        },
        scrollTo(id) {
            this.mobileMenuOpen = false;
            
            // Jika BUKAN home page, fungsi ini tidak melakukan apa-apa
            // membiarkan browser melakukan navigasi standar via href
            if (!this.isHomePage) return;

            // Jika DI home page, scroll manual & update active state
            const el = document.getElementById(id);
            if (el) {
                this.activeSection = id;
                el.scrollIntoView({ behavior: 'smooth' });
            }
        }
    }"
    class="fixed w-full z-50 bg-dark-950/80 backdrop-blur-md border-b border-primary/20 transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            <!-- Logo -->
            <div class="shrink-0 group cursor-pointer">
                <a href="/" class="text-3xl font-display font-bold text-white tracking-widest group-hover:text-glow transition-all uppercase">
                    @php
                        $names = explode(' ', $settings->site_name ?? 'SITE NAME');
                        $firstName = array_shift($names);
                        $lastName = implode(' ', $names);
                    @endphp
                    {{ $firstName }}<span class="text-primary">{{ $lastName }}</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-1">
                    
                    {{-- HOME --}}
                    <a href="{{ route('home') }}#home" 
                       @click="if(isHomePage) { $event.preventDefault(); scrollTo('home'); }"
                       :class="activeSection === 'home' ? 'text-primary border-primary bg-primary/10' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5'"
                       class="relative px-4 py-2 font-display font-bold tracking-wider transition-all border-b-2 cursor-pointer">
                        // HOME
                    </a>

                    {{-- SERVICES --}}
                    <a href="{{ route('home') }}#services" 
                       @click="if(isHomePage) { $event.preventDefault(); scrollTo('services'); }"
                       :class="activeSection === 'services' ? 'text-primary border-primary bg-primary/10' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5'"
                       class="relative px-4 py-2 font-display font-bold tracking-wider transition-all border-b-2 cursor-pointer">
                        // SERVICES
                    </a>

                    {{-- LOGS / EXPERIENCE --}}
                    <a href="{{ route('home') }}#experience" 
                       @click="if(isHomePage) { $event.preventDefault(); scrollTo('experience'); }"
                       :class="activeSection === 'experience' ? 'text-primary border-primary bg-primary/10' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5'"
                       class="relative px-4 py-2 font-display font-bold tracking-wider transition-all border-b-2 cursor-pointer">
                        // LOGS
                    </a>

                    {{-- PROJECTS --}}
                    <a href="{{ route('home') }}#projects" 
                       @click="if(isHomePage) { $event.preventDefault(); scrollTo('projects'); }"
                       :class="activeSection === 'projects' ? 'text-primary border-primary bg-primary/10' : 'text-slate-400 border-transparent hover:text-white hover:bg-white/5'"
                       class="relative px-4 py-2 font-display font-bold tracking-wider transition-all border-b-2 cursor-pointer">
                        // PROJECTS
                    </a>                                       

                </div>
            </div>

            <!-- CTA Button -->
            <div class="hidden md:block">
                <a href="{{ route('home') }}#contact" 
                   @click="if(isHomePage) { $event.preventDefault(); scrollTo('contact'); }"
                   class="clip-cut-corner bg-primary hover:bg-cyan-400 text-black px-6 py-2 font-display font-bold tracking-widest transition-all hover:shadow-[0_0_15px_rgba(0,240,255,0.5)]">
                    INITIATE_CHAT
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="text-primary hover:text-white p-2 transition-colors">
                    <i class="fa-solid fa-microchip text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-cloak
         x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden bg-dark-900 border-b border-white/10 shadow-xl absolute w-full">
        
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 font-display">
            
            <a href="{{ route('home') }}#home" 
               @click="if(isHomePage) { $event.preventDefault(); scrollTo('home'); } else { mobileMenuOpen = false; }"
               :class="activeSection === 'home' ? 'text-primary border-primary bg-primary/5' : 'text-white border-transparent hover:bg-white/5'"
               class="block px-3 py-4 text-lg font-bold border-l-2 transition-colors">
               >> HOME
            </a>

            <a href="{{ route('home') }}#services" 
               @click="if(isHomePage) { $event.preventDefault(); scrollTo('services'); } else { mobileMenuOpen = false; }"
               :class="activeSection === 'services' ? 'text-primary border-primary bg-primary/5' : 'text-white border-transparent hover:bg-white/5'"
               class="block px-3 py-4 text-lg font-bold border-l-2 transition-colors">
               >> SERVICES
            </a>

            <a href="{{ route('home') }}#experience" 
               @click="if(isHomePage) { $event.preventDefault(); scrollTo('experience'); } else { mobileMenuOpen = false; }"
               :class="activeSection === 'experience' ? 'text-primary border-primary bg-primary/5' : 'text-white border-transparent hover:bg-white/5'"
               class="block px-3 py-4 text-lg font-bold border-l-2 transition-colors">
               >> LOGS
            </a>
            
            <a href="{{ route('home') }}#projects" 
               @click="if(isHomePage) { $event.preventDefault(); scrollTo('projects'); } else { mobileMenuOpen = false; }"
               :class="activeSection === 'projects' ? 'text-primary border-primary bg-primary/5' : 'text-white border-transparent hover:bg-white/5'"
               class="block px-3 py-4 text-lg font-bold border-l-2 transition-colors">
               >> PROJECTS
            </a>
            
            <a href="{{ route('home') }}#contact" 
               @click="mobileMenuOpen = false"
               class="text-secondary block px-3 py-4 text-lg font-bold hover:bg-white/5 border-l-2 border-transparent">
               >> INITIATE_CHAT
            </a>
        </div>
    </div>
</nav>