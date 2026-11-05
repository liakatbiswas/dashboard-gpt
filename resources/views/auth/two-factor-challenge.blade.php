<x-guest-layout title="Two-Factor Authentication">
    <section class="auth-section">
        <div class="auth-card">
            <div class="auth-icon"><i class="mgc_safety_certificate_line" aria-hidden="true"></i></div>
            <h1 class="text-2xl font-semibold">দ্বিতীয় ধাপের যাচাই</h1>
            <p class="app-muted mt-3 mb-7 text-sm">Authenticator app-এর ৬ সংখ্যার কোড দাও।</p>
            <form method="POST" action="{{ route('two-factor.login.store') }}" class="space-y-5">
                @csrf
                <label for="code" class="form-label">Authentication code</label>
                <input id="code" type="text" name="code" inputmode="numeric" autocomplete="one-time-code"
                    pattern="[0-9]{6}" maxlength="6" required autofocus class="form-input otp-input"
                    aria-invalid="{{ $errors->has('code') ? 'true' : 'false' }}"
                    @if ($errors->has('code')) aria-describedby="code-error" @endif>
                @error('code')<p id="code-error" class="field-error" role="alert">{{ $message }}</p>@enderror
                <button type="submit" class="btn-primary w-full">কোড যাচাই করো</button>
            </form>
            <details class="mt-6 border-t app-divider pt-5" @if ($errors->has('recovery_code')) open @endif>
                <summary class="auth-link cursor-pointer rounded text-sm">Recovery code ব্যবহার করো</summary>
                <form method="POST" action="{{ route('two-factor.login.store') }}" class="mt-5 space-y-5">
                    @csrf
                    <label for="recovery_code" class="form-label">Recovery code</label>
                    <input id="recovery_code" type="text" name="recovery_code" autocomplete="off" spellcheck="false" required class="form-input"
                        aria-invalid="{{ $errors->has('recovery_code') ? 'true' : 'false' }}"
                        @if ($errors->has('recovery_code')) aria-describedby="recovery-code-error" @endif>
                    @error('recovery_code')<p id="recovery-code-error" class="field-error" role="alert">{{ $message }}</p>@enderror
                    <button type="submit" class="btn-secondary w-full">Recovery code দিয়ে প্রবেশ করো</button>
                </form>
            </details>
        </div>
    </section>
</x-guest-layout>
