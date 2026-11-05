@php
    $system = $record && in_array($record->name, config($catalog === 'roles' ? 'access.protected_roles' : 'access.system_permissions'), true);
    $ownerRole = $catalog === 'roles' && $record?->name === config('access.super_admin_role');
    $selected = $catalog === 'roles' ? array_map('strval', old('permissions', $record ? $record->permissions->modelKeys() : [])) : [];
@endphp
<div class="space-y-6">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="app-muted text-xs font-medium uppercase tracking-widest">Access management / {{ ucfirst($catalog) }}</p>
            <h1 class="mt-2 text-2xl font-semibold sm:text-3xl">{{ $record ? 'Edit' : 'Create' }} {{ $singular }}</h1>
        </div>
        <a href="{{ route($catalog.'.index') }}" class="btn-secondary">&larr; Back to {{ strtolower($catalog) }}</a>
    </div>
    <x-management-feedback />
    <form method="POST" action="{{ $record ? route($catalog.'.update', $record) : route($catalog.'.store') }}" class="space-y-6">
        @csrf
        @if ($record) @method('PUT') @endif
        <section class="app-panel">
            <div class="app-panel-heading"><h2 class="font-semibold">{{ $singular }} details</h2></div>
            <div class="space-y-5 p-5 sm:p-6">
                <x-form.input name="name" label="Name" :value="$record?->name" required maxlength="100" :readonly="$system"
                    :placeholder="$catalog === 'roles' ? 'exam-manager' : 'reports.export'" />
                <p class="app-muted text-xs">{{ $system ? 'This code is used by the application and cannot be renamed. You can edit its description.' : ($catalog === 'roles' ? 'Use lowercase letters, numbers, hyphens or underscores.' : 'Use a code such as reports.export. A new permission takes effect only where the application checks it.') }}</p>
                <x-form.textarea name="description" label="Description" :value="$record?->description" maxlength="500" rows="3" />
            </div>
        </section>
        @if ($catalog === 'roles')
            <section class="app-panel">
                <div class="app-panel-heading">
                    <h2 class="font-semibold">Permissions</h2>
                    <p class="app-muted mt-1 text-sm">{{ $ownerRole ? 'The single Super Admin has access to every permission automatically.' : 'Select the actions available to users with this role.' }}</p>
                </div>
                <fieldset class="grid min-w-0 gap-3 p-5 sm:grid-cols-2 sm:p-6 lg:grid-cols-3" @disabled($ownerRole)>
                    <legend class="sr-only">Role permissions</legend>
                    @foreach ($permissions as $permission)
                        @php $requiredForStudent = $record?->name === config('access.student_role') && $permission->name === 'student.dashboard.view'; @endphp
                        <label class="flex items-start gap-3 rounded-xl border app-divider p-3 text-sm">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->getKey() }}" class="form-checkbox mt-1 shrink-0"
                                @checked($ownerRole || $requiredForStudent || in_array((string) $permission->getKey(), $selected, true))
                                @disabled($requiredForStudent)>
                            @if ($requiredForStudent)<input type="hidden" name="permissions[]" value="{{ $permission->getKey() }}">@endif
                            <span class="min-w-0 break-words">{{ $permission->name }}@if ($requiredForStudent)<span class="app-muted block text-xs">Required for student sign-in</span>@endif</span>
                        </label>
                    @endforeach
                </fieldset>
            </section>
        @endif
        <div class="app-panel flex flex-wrap justify-end gap-3 px-5 py-4 sm:px-6">
            <a href="{{ route($catalog.'.index') }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary"><i class="mgc_check_line" aria-hidden="true"></i>{{ $record ? 'Save changes' : 'Create '.strtolower($singular) }}</button>
        </div>
    </form>
</div>
