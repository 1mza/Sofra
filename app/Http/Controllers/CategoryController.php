<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::when(request()->has('search'),function ($query){
            $query->where('name','like','%'.request('search').'%');
        })->latest()->simplePaginate(10);
        return view('admin-panel.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin-panel.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'name' => ['required','string','max:255',Rule::unique('categories','name')],
        ]);
        $category = Category::create($attributes);
        return redirect()->route('categories.show',compact('category'))->with('success',$attributes['name']." Category created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin-panel.categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin-panel.categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $attributes = request()->validate([
            'name' => ['required','string','max:255',Rule::unique('Categories','name')->ignore($category->id)],
        ]);
        $category->update($attributes);
        return redirect()->route('categories.show',compact('category'))->with('success',$attributes['name']." Category updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success',$category->name." Category deleted successfully");
    }
}
