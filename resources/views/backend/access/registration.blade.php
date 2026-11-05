<x-app-layout title="Student Registration">
    <div class="space-y-6">
        <div>
            <p class="app-muted text-xs font-medium uppercase tracking-widest">Access management</p>
            <h1 class="mt-2 text-2xl font-semibold sm:text-3xl">Student Registration</h1>
            <p class="app-muted mt-2 text-sm">Control whether new students can create an account.</p>
        </div>
        <x-management-feedback />
        <section class="app-panel overflow-hidden">
            <div class="app-panel-heading flex flex-wrap items-center justify-between gap-3">
                <h2 class="font-semibold">Public registration</h2>
                <span @class(['rounded-full px-3 py-1 text-xs font-medium', 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/15 dark:text-emerald-200' => $accessSetting->student_registration_enabled, 'bg-rose-50 text-rose-700 dark:bg-rose-500/15 dark:text-rose-200' => ! $accessSetting->student_registration_enabled])>
                    {{ $accessSetting->student_registration_enabled ? 'Open' : 'Closed' }}
                </span>
            </div>
            <form method="POST" action="{{ route('registration.update') }}" class="space-y-6 p-5 sm:p-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="student_registration_enabled" value="0">
                <label for="student_registration_enabled" class="flex cursor-pointer items-start gap-3 rounded-xl border app-divider p-4">
                    <input id="student_registration_enabled" type="checkbox" name="student_registration_enabled" value="1"
                        class="form-checkbox mt-1 shrink-0" @checked(old('student_registration_enabled', $accessSetting->student_registration_enabled))>
                    <span><span class="block text-sm font-semibold">Allow student registration</span>
                        <span class="app-muted mt-1 block text-sm">New accounts receive the student role automatically. Turning this off blocks new registrations and keeps existing student logins available.</span>
                    </span>
                </label>
                <p class="app-muted text-sm">When closed, Register links are hidden and direct registration requests are blocked.</p>
                @if ($accessSetting->updated_at)
                    <p class="app-muted text-xs">Last updated {{ $accessSetting->updated_at->format('d M Y, H:i') }}{{ $accessSetting->updatedBy ? ' by '.$accessSetting->updatedBy->name : '' }}.</p>
                @endif
                <button type="submit" class="btn-primary"><i class="mgc_check_line" aria-hidden="true"></i>Save registration setting</button>
            </form>
        </section>
    </div>
</x-app-layout>
