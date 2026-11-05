<x-guest-layout title="Student Dashboard">
    <section class="mx-auto w-full max-w-4xl space-y-6 px-4 py-10 sm:px-6 sm:py-14">
        <div>
            <p class="app-muted text-xs font-medium uppercase tracking-widest">Student workspace</p>
            <h1 class="mt-2 text-2xl font-semibold sm:text-3xl">Student Dashboard</h1>
            <p class="app-muted mt-2 text-sm">Welcome, {{ auth()->user()->name }}.</p>
        </div>
        <div class="app-panel p-6 sm:p-8">
            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-lg font-semibold">Your student account</h2>
                <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700 dark:bg-indigo-500/15 dark:text-indigo-200">Student</span>
            </div>
            <dl class="grid gap-6 sm:grid-cols-2">
                <div><dt class="app-muted text-xs">Full name</dt><dd class="mt-1 break-words font-medium">{{ auth()->user()->name }}</dd></div>
                <div><dt class="app-muted text-xs">Email address</dt><dd class="mt-1 break-all font-medium">{{ auth()->user()->email }}</dd></div>
                <div><dt class="app-muted text-xs">Joined</dt><dd class="mt-1 text-sm">{{ auth()->user()->created_at->format('d M Y') }}</dd></div>
            </dl>
            <div class="mt-8 border-t app-divider pt-5">
                <a href="{{ route('home') }}" class="btn-secondary"><i class="mgc_external_link_line" aria-hidden="true"></i>View school website</a>
            </div>
        </div>
    </section>
</x-guest-layout>
