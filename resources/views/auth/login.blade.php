<x-guest-layout title="NGHS || Login">
    <section class="auth-section">
        <div class="auth-card">
            <div class="auth-icon"><i class="mgc_lock_line" aria-hidden="true"></i></div>
            <p class="app-muted text-xs font-medium uppercase tracking-widest">School administration</p>
            <h1 class="mt-2 text-2xl font-semibold tracking-tight">Welcome back</h1>
            <p class="app-muted mt-2 mb-7 text-sm">Sign in to your account to continue.</p>
            @if (session('status'))<div class="notice-success mb-5" role="status">{{ session('status') }}</div>@endif
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <x-form.input name="email" label="Email address" type="email" required autofocus autocomplete="username" placeholder="you@example.com" />
                <x-form.input name="password" label="Password" type="password" required autocomplete="current-password" />
                <div class="flex flex-wrap items-center justify-between gap-3 text-sm">
                    <label class="app-muted flex cursor-pointer items-center gap-2"><input type="checkbox" name="remember" class="form-checkbox" @checked(old('remember'))>Remember me</label>
                    <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
                </div>
                <button type="submit" class="btn-primary w-full">Sign in<i class="mgc_arrow_right_line" aria-hidden="true"></i></button>
            </form>
            <p class="app-muted mt-6 border-t app-divider pt-5 text-center text-sm">Don't have an account? <a href="{{ route('register') }}" class="auth-link">Register</a></p>
        </div>
    </section>
</x-guest-layout>
