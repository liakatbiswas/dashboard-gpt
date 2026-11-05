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

    <script src="{{ asset('assets/js/theme.js') }}"></script>

    <!-- Tailwind CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="guest-shell flex min-h-screen flex-col bg-gray-50 text-gray-900 antialiased dark:bg-gray-950 dark:text-gray-100">

    {{-- ================= HEADER ================= --}}
    @include('layouts.guest-parts.header')

    {{-- ================= MAIN ================= --}}
    <main class="flex flex-1 flex-col">

        {{ $slot }}

    </main>

    {{-- ================= FOOTER ================= --}}
    @if (request()->routeIs('login', 'register', 'password.*', 'two-factor.*', 'verification.*', 'account.pending'))
        <footer class="app-muted border-t app-divider px-4 py-5 text-center text-xs">
            &copy; {{ date('Y') }} {{ $siteSettings?->site_title ?: 'School administration' }}. All rights reserved.
        </footer>
    @else
        @include('layouts.guest-parts.footer')
    @endif

</body>

</html>
