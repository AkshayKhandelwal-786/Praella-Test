<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Validator};
use App\Models\{Role, Permission};

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-role|assign-permission', ['only' => ['index']]);
        $this->middleware('permission:assign-permission', ['only' => ['updateAssignPermission']]);
    }
    public function index()
    {
        $role = Role::get();
        $primary = ROLE::ROLE_TYPE['Primary'];
        return view('pages.roles.index', compact('role', 'primary'));
    }
    public function updateAssignPermission(Request $request, $roleId)
    {
        DB::beginTransaction();
        try {
            $roleid = decrypt($roleId);
            $role = Role::find($roleid);
            if (!empty($role)) {
                if ($request->has('_token')) {
                    $validator = Validator::make($request->all(), [
                        'permissions' => 'required'
                    ]);
                    if ($validator->fails()) {
                        return redirect()->route('admin.assign-permission', $roleId)
                        ->withInput()->withErrors($validator->errors());
                    }else {
                        $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('id')->toArray();

                        $role->syncPermissions($permissionNames);
                        DB::commit();
                        return redirect()->route('roles.index')
                        ->with('success', trans('message.assign_permission'));
                    }
                }
                $permission = Permission::get()->groupBy('group');
                $rolePermission = $role->permissions()->select('id', 'group')->get();
                DB::commit();

                return view('pages.roles.assign_permission', compact('role', 'permission', 'rolePermission'));
            }else {
                return redirect()->route('admin.assign-permission', $roleId)
                ->with('error', trans('message.something_wrong'));
            }
        }catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.assign-permission', $roleId)->with('error', $e->getMessage());
        }
    }
}
