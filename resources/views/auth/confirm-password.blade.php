<x-guest-layout title="Confirm Password">
    <div class="mx-auto my-12 max-w-md rounded-xl bg-white p-6 shadow dark:bg-gray-800">
        <h1 class="mb-2 text-xl font-semibold">
            পাসওয়ার্ড নিশ্চিত করো
        </h1>

        <p class="mb-5 text-sm">
            এগিয়ে যেতে বর্তমান পাসওয়ার্ড দাও।
        </p>

        <form method="POST" action="{{ route('password.confirm.store') }}">
            @csrf

            <label for="password" class="mb-2 block">
                বর্তমান পাসওয়ার্ড
            </label>

            <input id="password" type="password" name="password" autocomplete="current-password" required autofocus
                class="w-full rounded border p-2 dark:bg-gray-900">

            @error('password')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

            <button type="submit" class="mt-4 w-full rounded bg-indigo-600 p-2 text-white">
                নিশ্চিত করো
            </button>
        </form>
    </div>
</x-guest-layout>
