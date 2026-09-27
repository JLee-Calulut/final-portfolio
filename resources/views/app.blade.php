<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Primary SEO -->
    <title inertia>John Lee Calulut — Frontend / Backend Developer</title>
    <meta name="description" content="John Lee Calulut — Frontend and Backend Developer specializing in Laravel, Vue.js and modern responsive web applications.">
    <meta name="keywords" content="John Lee Calulut, Laravel Developer, Vue.js Developer, PHP, JavaScript, Tailwind CSS, MySQL, Full-Stack Developer, Web Developer, Portfolio">
    <meta name="author" content="John Lee Liberato Calulut">
    <link rel="canonical" href="{{ url('/') }}">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="John Lee Calulut — Portfolio">
    <meta property="og:title" content="John Lee Calulut — Frontend / Backend Developer">
    <meta property="og:description" content="Frontend and Backend Developer specializing in Laravel, Vue.js and modern responsive web applications.">
    <meta property="og:url" content="{{ url('/') }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="John Lee Calulut — Frontend / Backend Developer">
    <meta name="twitter:description" content="Frontend and Backend Developer specializing in Laravel, Vue.js and modern responsive web applications.">

    <!-- Structured data -->
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => 'John Lee Liberato Calulut',
            'jobTitle' => 'Frontend / Backend Developer',
            'url' => url('/'),
            'knowsAbout' => ['Laravel', 'Vue.js', 'PHP', 'JavaScript', 'Tailwind CSS', 'MySQL', 'REST APIs'],
        ]) !!}
    </script>

    <!-- Favicon: orange "JC" monogram -->
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='14' fill='%23f97316'/%3E%3Ctext x='32' y='42' font-family='monospace' font-size='26' font-weight='700' text-anchor='middle' fill='%23050505'%3EJC%3C/text%3E%3C/svg%3E">

    <!-- Fonts (graceful fallback to system stack when offline) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body class="font-sans antialiased">
    @inertia
</body>
</html>
