<x-guest-layout title="Confirm Password">
    <section class="auth-section">
        <div class="auth-card">
            <div class="auth-icon"><i class="mgc_lock_line" aria-hidden="true"></i></div>
            <h1 class="text-2xl font-semibold">পাসওয়ার্ড নিশ্চিত করো</h1>
            <p class="app-muted mt-3 mb-7 text-sm">এগিয়ে যেতে বর্তমান পাসওয়ার্ড দাও।</p>
            <form method="POST" action="{{ route('password.confirm.store') }}" class="space-y-5">
                @csrf
                <x-form.input name="password" label="বর্তমান পাসওয়ার্ড" type="password" required autofocus autocomplete="current-password" />
                <button type="submit" class="btn-primary w-full">নিশ্চিত করো</button>
            </form>
            <p class="mt-6 border-t app-divider pt-5 text-center text-sm"><a href="{{ route('home') }}" class="auth-link">&larr; ওয়েবসাইটে ফিরে যাও</a></p>
        </div>
    </section>
</x-guest-layout>
