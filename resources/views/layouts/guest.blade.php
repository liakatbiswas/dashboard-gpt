@props([
    'title' => null,
])

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">

    <!-- title -->
    <title>{{ $title ?? config('app.name') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon"
        href="{{ $siteSettings?->favicon_url ?? asset('assets/images/logo/favicon.ico') }}"
        type="image/x-icon">

    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Pre-render theme check to prevent screen flickering -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Tailwind CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex min-h-screen flex-col bg-gray-50 text-gray-900 antialiased dark:bg-gray-950 dark:text-gray-100">

    {{-- ================= HEADER ================= --}}
    @include('layouts.guest-parts.header')

    {{-- ================= MAIN ================= --}}
    <main class="flex-1">

        {{ $slot }}

    </main>

    {{-- ================= FOOTER ================= --}}
    @include('layouts.guest-parts.footer')

</body>

</html>
