<x-guest-layout title="NGHS || Reset Password">
    <section class="auth-section">
        <div class="auth-card">
            <div class="auth-icon"><i class="mgc_key_2_line" aria-hidden="true"></i></div>
            <h1 class="text-2xl font-semibold tracking-tight">Set a new password</h1>
            <p class="app-muted mt-2 mb-7 text-sm">Choose a password to secure your account.</p>
            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <x-form.input name="email" label="Email address" type="email" :value="$request->email" required autofocus autocomplete="username" />
                <x-form.input name="password" label="New password" type="password" required autocomplete="new-password" />
                <x-form.input name="password_confirmation" label="Confirm new password" type="password" required autocomplete="new-password" />
                <button type="submit" class="btn-primary w-full">Reset password</button>
            </form>
            <p class="mt-6 border-t app-divider pt-5 text-center text-sm"><a href="{{ route('login') }}" class="auth-link">&larr; Back to sign in</a></p>
        </div>
    </section>
</x-guest-layout>
