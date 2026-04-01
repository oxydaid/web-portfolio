@inject('settings', 'App\Settings\GeneralSettings')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Failure | {{ $settings->site_name }}</title>

    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- VITE (CSS & JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- DYNAMIC COLORS -->
    <style>
        :root {
            --primary: {{ $settings->primary_color ?? '#00f0ff' }};
            --secondary: {{ $settings->secondary_color ?? '#bd00ff' }};
            --bg-dark: #050b14;
        }
    </style>
</head>
<body class="bg-dark-950 text-slate-300 font-sans antialiased selection:bg-primary selection:text-black relative">

    <!-- Background Grid -->
    <div class="fixed inset-0 cyber-grid pointer-events-none"></div>

    <div class="min-h-screen flex items-center justify-center relative overflow-hidden pt-20 pb-20">
        
        <!-- Background Glitch Decor -->
        <div class="absolute top-0 left-0 w-full h-full bg-dark-950 -z-20"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-150 h-150 bg-red-500/10 rounded-full blur-[150px] -z-10 animate-pulse"></div>

        <div class="text-center px-4 relative z-10 max-w-2xl mx-auto">
            
            <!-- Icon -->
            <div class="mb-8 inline-block relative">
                <i class="fa-solid fa-triangle-exclamation text-8xl text-red-500 animate-pulse"></i>
                <!-- Scanline overlay on icon -->
                <div class="absolute inset-0 bg-[linear-gradient(transparent_50%,rgba(0,0,0,0.5)_50%)] bg-size-[100%_4px] pointer-events-none"></div>
            </div>

            <!-- Glitch Text -->
            <h1 class="text-8xl md:text-9xl font-display font-bold text-white mb-2 tracking-tighter relative inline-block">
                404
                <span class="absolute top-0 left-0 -ml-1 text-red-500 opacity-70 animate-ping">404</span>
            </h1>

            <h2 class="text-2xl md:text-3xl font-display font-bold text-red-400 tracking-widest mb-6 uppercase">
                /// CRITICAL_SYSTEM_FAILURE
            </h2>

            <div class="bg-dark-900/80 border border-red-500/30 p-6 clip-cut-corner mb-10 text-left relative">
                <div class="absolute top-0 right-0 w-4 h-4 border-t border-r border-red-500"></div>
                <div class="absolute bottom-0 left-0 w-4 h-4 border-b border-l border-red-500"></div>
                
                <p class="font-mono text-sm text-slate-400 mb-2">
                    <span class="text-red-500">> ERROR_CODE:</span> PAGE_NOT_FOUND
                </p>
                <p class="font-mono text-sm text-slate-400 mb-2">
                    <span class="text-red-500">> DIAGNOSTIC:</span> The requested file path does not exist in the mainframe memory bank.
                </p>
                <p class="font-mono text-sm text-slate-400 animate-pulse">
                    <span class="text-red-500">> STATUS:</span> TERMINATED_CONNECTION
                </p>
            </div>

            <!-- Action Button -->
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-primary hover:bg-cyan-400 text-black font-display font-bold tracking-widest clip-cut-corner transition-all hover:scale-105 shadow-[0_0_20px_rgba(0,240,255,0.4)]">
                <i class="fa-solid fa-power-off"></i>
                INITIATE_SYSTEM_REBOOT
            </a>
            
        </div>
    </div>

</body>
</html>