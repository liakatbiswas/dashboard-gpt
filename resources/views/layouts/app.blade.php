@props([
'title' => null,
])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <!-- title -->
    <title>{{ $title ?? config('app.name') }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Theme Config Js -->
    <script src="{{ asset('assets/js/config.js') }}"></script>

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <!-- Begin page -->
    <div class="flex wrapper">

        <!-- Sidenav Menu -->
        @include('layouts.app-parts.sidenav')


        <div class="page-content">

            <!-- Topbar Start -->
            @include('layouts.app-parts.topbar')


            <main class="grow p-4">

                <div class="card p-6 min-h-screen flex flex-col items-center justify-center">
                    <h2 class="text-4xl text-center">Main</h2>
                </div>

            </main>

            <!-- Footer Start -->
            @include('layouts.app-parts.footer')

        </div>

    </div>

    <!-- Back to Top Button -->
    <button data-toggle="back-to-top"
        class="fixed hidden h-10 w-10 items-center justify-center rounded-full z-10 bottom-20 inset-e-14 p-2.5 bg-primary cursor-pointer shadow-lg text-white">
        <i class="mgc_arrow_up_line text-lg"></i>
    </button>

    <!-- Theme Settings -->
    @include('layouts.app-parts.theme-settings')

    <!-- Plugin Js -->
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/libs/%40frostui/tailwindcss/frostui.js') }}"></script>

    <!-- App Js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>