<?php

namespace BinaryCastle\Boilerplate\Http\Controllers\API;

use App\Http\Controllers\Controller;
use BinaryCastle\Boilerplate\Http\Requests\API\RoleRequest;
use BinaryCastle\Boilerplate\Http\Resources\RoleResource;
use BinaryCastle\Boilerplate\Models\Role;
use BinaryCastle\Boilerplate\Models\SideNavMenu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    protected string $role = 'Role';

    public function __construct()
    {
        $this->middleware(['permission:show role'])->only('index');
        $this->middleware(['permission:create role'])->only('store');
        $this->middleware(['permission:update role'])->only('update');
        $this->middleware(['permission:delete role'])->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $query = Role::whereLike(Role::class)->orderBySortable(Role::class);
        return RoleResource::collection($query->paginate($request->query('limit')))
            ->additional(['sortable_columns' => Role::getSortableColumns()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(RoleRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $permissions = Permission::whereIn('name', collect($request->permissions)->pluck('name'))->get();

            $role = Role::create(['name' => $request->name, 'guard_name' => 'sanctum']);
            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }

            $sidebar_menu = new SideNavMenu();
            $sidebar_menu->role_id = $role->id;
            $sidebar_menu->menu_json = $request->side_nav;
            $sidebar_menu->save();
            DB::commit();
            return response()->json(['message' => 'Role Created Successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $role = Role::with(['sideNav', 'permissions'])->findOrFail($id);
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function update(RoleRequest $request, $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $permissions = Permission::whereIn('name', collect($request->permissions)->pluck('name'))->get();
            $role = Role::findOrFail($id);
            if (!auth()->user()->is_admin && $role->is_default) {
                return response()->json(['message' => "{$role->name} default role is not update"], 400);
            }

            $role->name = $request->name;
            $role->save();
            $role->revokePermissionTo($role->permissions);
            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }

            $sidebar_menu = SideNavMenu::where('role_id', $role->id)->firstOrFail();
            $sidebar_menu->role_id = $role->id;
            $sidebar_menu->menu_json = $request->side_nav;
            $sidebar_menu->save();
            DB::commit();
            return response()->json(['message' => 'Role updated Successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $role = Role::findOrFail($id);
        if ($role->is_default) {
            return response()->json(['message' => "{$role->name} default role is not deleted"], 400);
        }

        SideNavMenu::where('role_id', $role->id)->delete();
        if ($role->delete()) {
            return response()->json(['message' => 'Role deleted successfully']);
        }
        return response()->json(['message' => 'Something went wrong'], 400);
    }

    /**
     * Get all permissions form permissions table
     * @return JsonResponse
     */
    public function getAllPermission(): JsonResponse
    {
        $permissions = Permission::select('icon', 'name', 'sidebar_menu', 'description', 'url', 'label', 'group')->get();
        if (request()->query('group-by')) {
            $permissions = $permissions->groupBy(request()->query('group-by'));
        }
        return response()->json($permissions);
    }
}
