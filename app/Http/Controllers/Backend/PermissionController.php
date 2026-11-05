<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SavePermissionRequest;
use App\Services\Access\PermissionManagementService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct(private PermissionManagementService $service) {}

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Permission::class);
        $filters = $request->validate(['q' => ['nullable', 'string', 'max:100']]);
        $query = $filters['q'] ?? '';
        $records = Permission::query()->where('guard_name', 'web')->withCount(['roles', 'users'])
            ->when($query !== '', fn ($builder) => $builder->where('name', 'like', '%'.$query.'%'))
            ->orderBy('name')->paginate(12)->withQueryString();

        return view('backend.access.permissions.index', compact('records', 'query'));
    }

    public function create(): View
    {
        Gate::authorize('create', Permission::class);

        return view('backend.access.permissions.create');
    }

    public function store(SavePermissionRequest $request): RedirectResponse
    {
        Gate::authorize('create', Permission::class);
        $this->service->save(null, $request->validated());

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission): View
    {
        abort_unless($permission->guard_name === 'web', 404);
        Gate::authorize('update', $permission);

        return view('backend.access.permissions.edit', ['permission' => $permission]);
    }

    public function update(SavePermissionRequest $request, Permission $permission): RedirectResponse
    {
        abort_unless($permission->guard_name === 'web', 404);
        Gate::authorize('update', $permission);
        $this->service->save($permission, $request->validated());

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission): RedirectResponse
    {
        abort_unless($permission->guard_name === 'web', 404);
        Gate::authorize('delete', $permission);
        $this->service->delete($permission);

        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
