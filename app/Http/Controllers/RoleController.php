<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Pagination\Paginator;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware() : array
    {
        return [
            new Middleware('permission:roles list', only: ['index']),
            new Middleware('permission:add role', only: ['store']),
            new Middleware('permission:edit role', only: ['update']),
            new Middleware('permission:delete role', only: ['destroy']),

        ];
    }

    public function  index()
    {
        $permissions = Permission::orderBy('created_at','ASC')->get();
        $roles = Role::orderBy('created_at','ASC')->paginate(3);

        return view('backend.roles.roles',compact('permissions','roles'));
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles|min:3',
        ]);

        if ($validator->passes()) {
            $role = Role::create(['name' => $request->name]);

            if (!empty($request->permission)) {
                foreach ($request->permission as $name) {
                    $role->givePermissionTo($name);
                }
            }
            return redirect()->route('roles')->with(['success' => 'Role created successfully']);
        }
        else
        {
            return redirect()->route('roles',['modal'=> true])->withInput()->withErrors($validator);
        }
    }



    public function update($id, Request $request) {
        $role = Role::findOrFail ($id);
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:roles,name, '.$id.',id'
        ]);
        if ($validator->passes()) {
            $role->name = $request->name;
            $role->save();
                if (!empty($request->permission)) {
                    $role->syncPermissions($request->permission);

            }else{
                $role->syncPermissions([]);
            }
            return redirect()->route('roles')->with('success', 'Role updated successfully.');
        }
        else
        {
            return redirect()->route('roles')->withInput()->withErrors($validator);
        }
    }


    public function destroy(Request $request)
    {
        $id = $request->id;
        $role = Role::find($id);
        if ($role == null) {
            $request->session()->flash('successs', 'Role not found.');
            return response()->json(['status' => false]);
        }

        $role->delete();
        $request->session()->flash('successs', 'Role deleted successfully.');
        return response()->json(['status' => true]);

    }


}
