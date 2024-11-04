<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:users list', only: ['index']),
            new Middleware('permission:add user', only: ['store']),
            new Middleware('permission:edit user', only: ['update']),
            new Middleware('permission:delete user', only: ['destroy']),

        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);
        $roles = Role::orderBy('name','ASC')->get();
        return view('backend.users.users',compact('users','roles'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $user=  User::create([
            'name' => $request->name,
            'email' =>  $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,

        ]);



        if ($request->has('role')) {
            $user->syncRoles($request->role);
        }

        return redirect()->route('users')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $user->id, // Ensure primary key is correct
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();


        if ($request->has('role')) {
            $user->syncRoles($request->role);
        }

        return redirect()->route('users')->with('success', 'User updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
{
    $id = $request->id;
    $user = User::with('roles')->find($id);

    if ($user === null) {
        $request->session()->flash('successs', 'User not found.');
        return response()->json(['status' => false]);
    }

    if ($user->roles) {
        $user->syncRoles([]);
    }

    // Delete the user
    $user->delete();

    $request->session()->flash('successs', 'User deleted successfully.');
    return response()->json(['status' => true]);
}

}
