<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::when(request()->has('search'), function ($query) {
            $filteredColumns = ['name', 'email'];
            $query->where(function ($query) use ($filteredColumns) {
                foreach ($filteredColumns as $column) {
                    $query->orWhere($column, 'LIKE', '%' . request('search') . '%');
                }
            });
        })->with('roles')->latest()->simplePaginate(10);
        return view('admin-panel.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin-panel.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
            'role' => ['nullable', 'array'],
            'role.*' => ['nullable', Rule::exists('roles', 'name')],
        ]);
        $attributes['password'] = Hash::make($attributes['password']);
        $user = User::create($attributes);
        $user->assignRole($attributes['role']);
        return redirect()->route('users.index')->with('success', "User $user->name created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin-panel.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {

        $roles = Role::all();
        return view('admin-panel.users.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $attributes = $request->validate([
            'name' => ['sometimes'],
            'email' => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['nullable', 'array'],
            'role.*' => ['nullable', Rule::exists('roles', 'name')],
        ]);
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['sometimes', 'confirmed', Password::min(8)],
            ]);
            $attributes['password'] = Hash::make($request->input('password'));
        } else {
            unset($attributes['password']);
        }
        $user->update($attributes);
        if (isset($attributes['role'])) {
            $user->syncRoles($attributes['role']);
        } else {
            $user->syncRoles([]);
        }
        return redirect()->route('users.index')->with('success', "User $user->name updated successfully");
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', "User $user->name deleted successfully");
    }
}
