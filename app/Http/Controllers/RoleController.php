<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct(){
        $this->authorizeResource(Role::class, 'role');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::when(request()->has('search'),function ($query){
            $query->where('name','like','%'.request('search').'%');
        })->latest()->simplePaginate(10);
        return view('admin-panel.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-panel.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'name' => ['required','string','max:255',Rule::unique('roles','name')],
        ]);
        $role = Role::create($attributes);
        return redirect()->route('roles.index')->with('success',$attributes['name']." Role created successfully");
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin-panel.roles.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $attributes = request()->validate([
            'name' => ['required','string','max:255',Rule::unique('roles','name')->ignore($role)],
        ]);
        $role->update($attributes);
        return redirect()->route('roles.index')->with('success',$attributes['name']." Role updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success',$role->name." Role deleted successfully");
    }
}
