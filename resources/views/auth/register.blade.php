<x-guest-layout title="NGHS || Register">
    <section class="auth-section">
        <div class="auth-card">
            <div class="auth-icon"><i class="mgc_user_add_line" aria-hidden="true"></i></div>
            <h1 class="text-2xl font-semibold tracking-tight">Create an account</h1>
            <p class="app-muted mt-2 mb-7 text-sm">Enter your details to get started.</p>
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                <x-form.input name="name" label="Full name" required autofocus autocomplete="name" maxlength="255" />
                <x-form.input name="email" label="Email address" type="email" required autocomplete="username" maxlength="255" />
                <x-form.input name="password" label="Password" type="password" required autocomplete="new-password" />
                <x-form.input name="password_confirmation" label="Confirm password" type="password" required autocomplete="new-password" />
                <button type="submit" class="btn-primary w-full">Create account<i class="mgc_arrow_right_line" aria-hidden="true"></i></button>
            </form>
            <p class="app-muted mt-6 border-t app-divider pt-5 text-center text-sm">Already have an account? <a href="{{ route('login') }}" class="auth-link">Sign in</a></p>
        </div>
    </section>
</x-guest-layout>
