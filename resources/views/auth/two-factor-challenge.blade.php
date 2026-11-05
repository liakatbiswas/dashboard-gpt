<x-guest-layout title="Two-Factor Authentication">
    <div class="mx-auto my-12 max-w-md rounded-xl bg-white p-6 shadow dark:bg-gray-800">
        <h1 class="mb-2 text-xl font-semibold">
            দ্বিতীয় ধাপের যাচাই
        </h1>

        <p class="mb-5 text-sm">
            Authenticator app-এর ৬ সংখ্যার কোড দাও।
        </p>

        <form method="POST" action="{{ route('two-factor.login.store') }}">
            @csrf

            <label for="code" class="mb-2 block">
                Authentication code
            </label>

            <input id="code" type="text" name="code" inputmode="numeric" autocomplete="one-time-code"
                pattern="[0-9]{6}" maxlength="6" required autofocus class="w-full rounded border p-2 dark:bg-gray-900">

            @error('code')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

            <button type="submit" class="mt-4 w-full rounded bg-indigo-600 p-2 text-white">
                কোড যাচাই করো
            </button>
        </form>

        <details class="mt-6" @if ($errors->has('recovery_code')) open @endif>
            <summary class="cursor-pointer">
                Recovery code ব্যবহার করো
            </summary>

            <form method="POST" action="{{ route('two-factor.login.store') }}" class="mt-4">
                @csrf

                <label for="recovery_code" class="mb-2 block">
                    Recovery code
                </label>

                <input id="recovery_code" type="text" name="recovery_code" autocomplete="off" required
                    class="w-full rounded border p-2 dark:bg-gray-900">

                @error('recovery_code')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

                <button type="submit" class="mt-4 w-full rounded bg-indigo-600 p-2 text-white">
                    Recovery code দিয়ে প্রবেশ করো
                </button>
            </form>
        </details>
    </div>
</x-guest-layout>
