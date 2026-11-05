<x-guest-layout title="Student Registration Closed">
    <section class="auth-section">
        <div class="auth-card">
            <div class="auth-icon"><i class="mgc_lock_line" aria-hidden="true"></i></div>
            <h1 class="text-2xl font-semibold">Registration is closed</h1>
            <p class="app-muted mt-4 text-sm leading-7">Student registration is currently closed. Existing students can still sign in.</p>
            <a href="{{ route('login') }}" class="btn-primary mt-6 w-full">Student sign in</a>
            <a href="{{ route('home') }}" class="btn-secondary mt-3 w-full">Back to website</a>
        </div>
    </section>
</x-guest-layout>
