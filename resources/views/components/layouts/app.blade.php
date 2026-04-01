@inject('settings', 'App\Settings\GeneralSettings')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- DYNAMIC TITLE -->
    <title>{{ !empty($title) ? $title . ' | ' . $settings->site_name : $settings->site_name . ' | ' . ($settings->dev_title ?? '') }}</title>

    <!-- FAVICON -->
    @if(!empty($settings->site_favicon))
        <link rel="icon" href="{{ Storage::url($settings->site_favicon) }}">
    @endif

    <!-- META SEO -->
    <meta name="description" content="{{ $description ?? $settings->site_description }}">
    <meta name="author" content="{{ $author ?? $settings->dev_name }}">
    <meta name="keywords" content="{{ $keywords ?? 'Developer, Portfolio, Web Developer, Fullstack' }}">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ !empty($title) ? $title . ' | ' . $settings->site_name : $settings->site_name }}">
    <meta property="og:description" content="{{ $description ?? $settings->site_description }}">
    <meta property="og:site_name" content="{{ $settings->site_name }}">
    @if(!empty($image) || !empty($settings->site_logo))
        <meta property="og:image" content="{{ !empty($image) ? $image : Storage::url($settings->site_logo) }}">
    @endif

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ !empty($title) ? $title . ' | ' . $settings->site_name : $settings->site_name }}">
    <meta name="twitter:description" content="{{ $description ?? $settings->site_description }}">
    @if(!empty($image) || !empty($settings->site_logo))
        <meta name="twitter:image" content="{{ !empty($image) ? $image : Storage::url($settings->site_logo) }}">
    @endif
    
    <!-- CANONICAL URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }

        :root {
            --primary:
                {{ $settings->primary_color ?? '#00f0ff' }}
            ;
            --secondary:
                {{ $settings->secondary_color ?? '#bd00ff' }}
            ;
        }
    </style>
</head>

<body class="bg-dark-950 text-slate-300 font-sans antialiased selection:bg-primary selection:text-black relative">

    <!-- Background Grid -->
    <div class="fixed inset-0 cyber-grid pointer-events-none"></div>

    <x-navbar />

    <!-- MAIN CONTENT SLOT -->
    <main>
        {{ $slot }}
    </main>

    <x-footer />
</body>

</html>