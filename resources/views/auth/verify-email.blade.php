<x-guest-layout title="NGHS || Verify Email">
    <section class="auth-section">
        <div class="auth-card">
            <div class="auth-icon"><i class="mgc_mail_line" aria-hidden="true"></i></div>
            <h1 class="text-2xl font-semibold">Verify your email</h1>
            <p class="app-muted mt-3 mb-7 text-sm">Please verify your email address by clicking the link we emailed to you.</p>
            @if (session('status') === 'verification-link-sent')
                <div class="notice-success mb-5" role="status">A new verification link has been sent to your email address.</div>
            @endif
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary w-full">Resend verification email</button>
            </form>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="btn-secondary w-full">Log out</button>
            </form>
        </div>
    </section>
</x-guest-layout>
