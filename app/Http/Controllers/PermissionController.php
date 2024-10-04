<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::when(request()->has('search'), function ($query) {
            $query->where('name', 'like', '%' . request('search') . '%')
                ->orWhereHas('roles', function ($query) {
                    $query->where('name', 'like', '%' . request('search') . '%');
                });
        })->with('roles')->latest()->simplePaginate(10);
        return view('admin-panel.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin-panel.permissions.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')],
            'role' => ['nullable', 'array'],
            'role.*' => ['nullable', Rule::exists('roles', 'name')],
        ]);
        $permission = Permission::create($attributes);
        $permission->assignRole(request('role'));
        return redirect()->route('permissions.index')->with('success', $attributes['name'] . " Permission created successfully");

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        $roles = Role::all();
        return view('admin-panel.permissions.edit', compact('roles', 'permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $attributes = request()->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($permission->id)],
            'role' => ['nullable', 'array'],
            'role.*' => ['nullable', Rule::exists('roles', 'name')],
        ]);
        $permission->update($attributes);
        if (isset($attributes['role'])) {
            $permission->syncRoles($attributes['role']);
        } else {
            $permission->syncRoles([]);
        }
//        $permission->assignRole(request('role'));
        return redirect()->route('permissions.index')->with('success', $attributes['name'] . " Permission updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', $permission->name . " Permission deleted successfully");
    }
}
