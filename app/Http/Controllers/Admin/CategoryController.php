<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        return view('Admin.Category.list');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::select('categories.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.category.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                    $btn .= ' <a href="javascript:void(0);" data-id="' . $row->id . '" class="btn btn-sm btn-danger delete-category">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('Admin.Category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name'
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Category Create Successfully.');
    }

    public function edit($id)
    {
        $category = Category::where('id', $id)->first();
        return view('Admin.Category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id,
        ]);

        $category = Category::findOrFail($id);

        $category->name = $request->name;
        $category->save();

        return redirect()->route('admin.category')->with('success', 'Category updated successfully.');
    }


    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }

}
