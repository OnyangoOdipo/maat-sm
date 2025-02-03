<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $allPermissions = Permission::all();

        // dd($roles, $allPermissions);

        return view('admin.roles-permissions', compact('roles', 'allPermissions'));
    }

    public function storePermissionOrRole(Request $request, $type)
    {
        try {
            if ($type === 'permission') {
                $permission = Permission::create(['name' => strtolower(str_replace(' ', '_', $request->name))]);
                return response()->json([
                    'success' => true,
                    'message' => "Permission created successfully",
                    'permission' => $permission
                ]);
            } else {
                $role = Role::create(['name' => $request->name]);
                return response()->json([
                    'success' => true,
                    'message' => "Role created successfully",
                    'role' => $role
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating permission or role: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updatePermissions(Request $request, $role)
    {
        try {
            $permission = Permission::findOrFail($request->permission_id);

            if ($request->action === 'delete') {
                if ($request->from_role_id) {
                    $oldRole = Role::findOrFail($request->from_role_id);
                    $oldRole->revokePermissionTo($permission);
                    return response()->json([
                        'success' => true,
                        'message' => "Permission removed from role successfully",
                        'role' => $oldRole->load('permissions')
                    ]);
                }
            } else {
                // If moving from another role, remove it first
                if ($request->from_role_id) {
                    $oldRole = Role::findOrFail($request->from_role_id);
                    $oldRole->revokePermissionTo($permission);
                }

                $role->givePermissionTo($permission);

                return response()->json([
                    'success' => true,
                    'message' => "Permission updated successfully",
                    'role' => $role->load('permissions')
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating permissions: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deletePermission(Permission $permission)
    {
        try {
            $permission->delete();
            return response()->json([
                'success' => true,
                'message' => "Permission deleted successfully"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting permission: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteRole(Role $role)
    {
        try {
            $role->delete();
            return response()->json([
                'success' => true,
                'message' => "Role deleted successfully"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting role: ' . $e->getMessage()
            ], 500);
        }
    }

    public function assignRolesView()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('admin.assign-roles', compact('roles', 'users'));
    }

    public function assignRoles(Request $request)
    {
        try {
            $user = User::findOrFail($request->user);
            $user->syncRoles($request->roles);
            return response()->json([
                'success' => true,
                'message' => "Roles assigned successfully",
                'user' => $user->load('roles')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error assigning roles: ' . $e->getMessage()
            ], 500);
        }
    }
}
