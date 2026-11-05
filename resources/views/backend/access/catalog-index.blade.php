<x-app-layout :title="$label">
    <div class="space-y-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="app-muted text-xs font-medium uppercase tracking-widest">Access management</p>
                <h1 class="mt-2 text-2xl font-semibold sm:text-3xl">{{ $label }}</h1>
                <p class="app-muted mt-2 text-sm">{{ $catalog === 'roles' ? 'Organize permissions into reusable roles.' : 'Define the actions available to your roles.' }}</p>
            </div>
            <a href="{{ route($catalog.'.create') }}" class="btn-primary"><i class="mgc_add_line" aria-hidden="true"></i>Create {{ $singular }}</a>
        </div>
        <x-management-feedback />
        <section class="app-panel overflow-hidden">
            <div class="app-panel-heading flex flex-wrap items-center justify-between gap-4">
                <p class="text-sm font-medium">{{ number_format($records->total()) }} {{ strtolower($label) }}</p>
                <form method="GET" action="{{ route($catalog.'.index') }}" class="flex w-full gap-2 sm:w-auto">
                    <label for="catalog-search" class="sr-only">Search {{ strtolower($label) }}</label>
                    <input id="catalog-search" name="q" type="search" value="{{ $query }}" maxlength="100" placeholder="Search by name" class="form-input sm:w-64">
                    <button type="submit" class="btn-secondary">Search</button>
                    @if ($query !== '')<a href="{{ route($catalog.'.index') }}" class="btn-secondary">Reset</a>@endif
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[640px] text-start text-sm">
                    <thead class="border-b app-divider bg-slate-50 dark:bg-slate-900/30">
                        <tr class="app-muted">
                            <th scope="col" class="px-6 py-4 text-start font-medium">{{ $singular }}</th>
                            <th scope="col" class="px-5 py-4 text-start font-medium">{{ $catalog === 'roles' ? 'Permissions' : 'Roles' }}</th>
                            <th scope="col" class="px-5 py-4 text-start font-medium">Users</th>
                            <th scope="col" class="px-6 py-4 text-end font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            @php
                                $system = in_array($record->name, config($catalog === 'roles' ? 'access.protected_roles' : 'access.system_permissions'), true);
                                $cannotDelete = $system || ($catalog === 'roles' && $record->users_count > 0);
                            @endphp
                            <tr class="border-b app-divider last:border-b-0">
                                <td class="px-6 py-5">
                                    <a href="{{ route($catalog.'.edit', $record) }}" class="font-semibold hover:text-indigo-600 dark:hover:text-indigo-300">{{ $record->name }}</a>
                                    @if ($system)<span class="ms-2 rounded bg-indigo-50 px-2 py-0.5 text-xs text-indigo-700 dark:bg-indigo-500/15 dark:text-indigo-200">System</span>@endif
                                    @if ($record->description)<p class="app-muted mt-1 max-w-sm break-words text-xs">{{ $record->description }}</p>@endif
                                </td>
                                <td class="px-5 py-5">
                                    @if ($catalog === 'roles')
                                        {{ $record->name === config('access.super_admin_role') ? 'All permissions' : $record->permissions_count }}
                                    @else
                                        {{ $record->roles_count }}
                                    @endif
                                </td>
                                <td class="px-5 py-5">{{ $record->users_count }}</td>
                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route($catalog.'.edit', $record) }}" class="btn-secondary" aria-label="Edit {{ $record->name }}">Edit</a>
                                        <form method="POST" action="{{ route($catalog.'.destroy', $record) }}"
                                            data-confirm="{{ $catalog === 'roles' ? 'Delete this role?' : 'Delete this permission? It will be removed from every assigned role and user.' }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-secondary" @disabled($cannotDelete)
                                                title="{{ $system ? 'System records cannot be deleted' : ($cannotDelete ? 'This role is assigned to users' : 'Delete '.$record->name) }}"
                                                aria-label="Delete {{ $record->name }}">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="app-muted px-6 py-12 text-center">No {{ strtolower($label) }} found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($records->hasPages())<div class="border-t app-divider px-6 py-4">{{ $records->links() }}</div>@endif
        </section>
    </div>
</x-app-layout>
