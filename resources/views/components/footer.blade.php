@inject('settings', 'App\Settings\GeneralSettings')

<footer class="py-10 border-t border-white/10 bg-dark-950 text-center relative z-10">
    <div class="max-w-7xl mx-auto px-4">
        
        <!-- Social Links Loop -->
        @if($settings->social_links)
        <div class="flex justify-center gap-6 mb-6">
            @foreach($settings->social_links as $social)
                <a href="{{ $social['url'] }}" target="_blank" class="text-slate-500 hover:text-primary transition-colors transform hover:scale-110">
                    {{-- Kita pakai icon dinamis berdasarkan nama platform --}}
                    @if($social['platform'] == 'github') <i class="fa-brands fa-github"></i>
                    @elseif($social['platform'] == 'linkedin') <i class="fa-brands fa-linkedin"></i>
                    @elseif($social['platform'] == 'instagram') <i class="fa-brands fa-instagram"></i>
                    @elseif($social['platform'] == 'facebook') <i class="fa-brands fa-facebook"></i>
                    @elseif($social['platform'] == 'telegram') <i class="fa-brands fa-telegram"></i>
                    @elseif($social['platform'] == 'whatsapp') <i class="fa-brands fa-whatsapp"></i>
                    @elseif($social['platform'] == 'discord') <i class="fa-brands fa-discord"></i>
                    @elseif($social['platform'] == 'tiktok')  <i class="fa-brands fa-tiktok"></i>
                    @elseif($social['platform'] == 'twitter') <i class="fa-brands fa-twitter"></i>
                    @elseif($social['platform'] == 'youtube') <i class="fa-brands fa-youtube"></i>
                    @else <i class="fa-solid fa-link w-5 h-5"></i>
                    @endif
                </a>
            @endforeach
        </div>
        @endif

        <p class="text-slate-600 text-xs font-mono tracking-widest">
            SYSTEM_ID: {{ strtoupper($settings->site_name) }} // COPYRIGHT &copy; {{ date('Y') }}
        </p>
    </div>
</footer>