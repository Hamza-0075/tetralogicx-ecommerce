<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware() : array
    {
        return [
            new Middleware('permission:permissions list', only: ['index']),
            new Middleware('permission:add Permission', only: ['store']),
            new Middleware('permission:edit Permission', only: ['update']),
            new Middleware('permission:delete Permission', only: ['destroy']),

        ];
    }

    public function index()
    {
        $permissions=Permission::orderBy('created_at','DESC')->paginate(10);
        return view('backend.permissions.permissions',compact('permissions'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3',
        ]);

        if ($validator->passes()) {
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions')->with('success', 'Permission created successfully');
        }
        else
        {
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }

    public function destroy($id){
        $permission = Permission::find($id);
        if ($permission) {
            $permission->delete();
            return redirect()->back()->with('success', 'Permission deleted successfully');
        }
        else
        {
            return redirect()->back()->with('error', 'Permission not found');
        }
    }


    public function  edit($id)
    {
        $permission = Permission::findorFail($id);
        return view('backend.permissions.editPermissions',compact('permission'));
    }

    public function update($id, Request $request)
    {
        $permission = Permission::findorFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:permissions,name,'.$id.',id'
        ]);

        if ($validator->passes()) {
            // Permission::create(['name' => $request->name]);
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions')->with('success', 'Permission updated Successfully');
        }
        else
        {
            return redirect()->back()->withInput()->withErrors($validator);
        }
    }
}
