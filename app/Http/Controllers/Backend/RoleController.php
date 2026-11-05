<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SaveRoleRequest;
use App\Services\Access\RoleManagementService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(private RoleManagementService $service) {}

    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Role::class);
        $filters = $request->validate(['q' => ['nullable', 'string', 'max:100']]);
        $query = $filters['q'] ?? '';
        $records = Role::query()->where('guard_name', 'web')->withCount(['users', 'permissions'])
            ->when($query !== '', fn ($builder) => $builder->where('name', 'like', '%'.$query.'%'))
            ->orderBy('name')->paginate(12)->withQueryString();

        return view('backend.access.roles.index', compact('records', 'query'));
    }

    public function create(): View
    {
        Gate::authorize('create', Role::class);

        return view('backend.access.roles.create', ['permissions' => Permission::query()->where('guard_name', 'web')->orderBy('name')->get()]);
    }

    public function store(SaveRoleRequest $request): RedirectResponse
    {
        Gate::authorize('create', Role::class);
        $this->service->save(null, $request->validated());

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role): View
    {
        abort_unless($role->guard_name === 'web', 404);
        Gate::authorize('update', $role);

        return view('backend.access.roles.edit', ['role' => $role->load('permissions'), 'permissions' => Permission::query()->where('guard_name', 'web')->orderBy('name')->get()]);
    }

    public function update(SaveRoleRequest $request, Role $role): RedirectResponse
    {
        abort_unless($role->guard_name === 'web', 404);
        Gate::authorize('update', $role);
        $this->service->save($role, $request->validated());

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role): RedirectResponse
    {
        abort_unless($role->guard_name === 'web', 404);
        Gate::authorize('delete', $role);
        $this->service->delete($role);

        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
