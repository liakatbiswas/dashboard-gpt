<x-guest-layout title="NGHS || Forgot Password">
    <section class="auth-section">
        <div class="auth-card">
            <div class="auth-icon"><i class="mgc_mail_line" aria-hidden="true"></i></div>
            <h1 class="text-2xl font-semibold tracking-tight">Forgot your password?</h1>
            <p class="app-muted mt-2 mb-7 text-sm">Enter your email and we'll send you a password reset link.</p>
            @if (session('status'))<div class="notice-success mb-5" role="status">{{ session('status') }}</div>@endif
            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <x-form.input name="email" label="Email address" type="email" required autofocus autocomplete="email" placeholder="you@example.com" />
                <button type="submit" class="btn-primary w-full">Send reset link</button>
            </form>
            <p class="mt-6 border-t app-divider pt-5 text-center text-sm"><a href="{{ route('login') }}" class="auth-link">&larr; Back to sign in</a></p>
        </div>
    </section>
</x-guest-layout>
