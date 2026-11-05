<x-guest-layout title="Dashboard Access">
    <section class="auth-section">
        <div class="auth-card">
            <div class="auth-icon"><i class="mgc_time_line" aria-hidden="true"></i></div>
            <p class="app-muted text-xs font-medium uppercase tracking-widest">Account access</p>
            <h1 class="mt-2 text-2xl font-semibold">অনুমতির অপেক্ষায়</h1>
            <p class="app-muted mt-4 text-sm leading-7">
                আপনার অ্যাকাউন্ট তৈরি হয়েছে। এই অ্যাকাউন্টে এখনো Dashboard ব্যবহারের অনুমতি দেওয়া হয়নি।
                Administrator প্রয়োজনীয় role বা permission দেওয়ার পর Dashboard ব্যবহার করতে পারবেন।
            </p>

            <div class="my-6 rounded-xl border app-divider px-4 py-3">
                <p class="text-sm font-semibold break-words">{{ auth()->user()->name }}</p>
                <p class="app-muted mt-1 break-all text-sm">{{ auth()->user()->email }}</p>
            </div>

            <p class="app-muted mb-5 text-sm">অনুমতি পাওয়ার পর নিচের বাটনে চাপুন।</p>
            <div class="space-y-3">
                <a href="{{ route('account.pending') }}" class="btn-primary w-full">
                    <i class="mgc_refresh_1_line" aria-hidden="true"></i>আবার যাচাই করুন
                </a>
                @can('settings.view')
                    <a href="{{ route('settings.edit') }}" class="btn-secondary w-full">Site Settings খুলুন</a>
                @endcan
                <a href="{{ route('home') }}" class="btn-secondary w-full">ওয়েবসাইটে যান</a>
            </div>

            <form method="POST" action="{{ route('logout') }}" class="mt-6 border-t app-divider pt-5">
                @csrf
                <button type="submit" class="auth-link w-full text-center text-sm">Log out</button>
            </form>
        </div>
    </section>
</x-guest-layout>
