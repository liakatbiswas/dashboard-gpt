@props([
'title' => null,
])

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <title>{{ $title ?? config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- পেজ লোডের সময় ফ্লিকারিং রোধ করার জন্য প্রি-রেন্ডার চেক -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Tailwind CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{--
    SPACING SYSTEM (সব জায়গায় একই নিয়ম)
    ─ Container     : mx-auto w-full max-w-7xl px-4 sm:px-6 lg:px-8
    ─ Section       : py-16 sm:py-20 lg:py-24
    ─ Section head  : mb-10 (eyebrow → mt-2 title → mt-3 text)
    ─ Grid gap      : gap-6 (cards)  /  gap-10 lg:gap-14 (two-column layouts)
    ─ Card padding  : p-6
--}}

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