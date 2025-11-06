<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ColorController extends Controller
{
    public function index()
    {
        return view('Admin.Color.list');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Color::select('name', 'code', 'id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.color.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                    $btn .= ' <a href="javascript:void(0);" data-id="' . $row->id . '" class="btn btn-sm btn-danger delete-color">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('Admin.Color.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:colors,code'
        ]);

        Color::create([
            'name' => $request->name,
            'code' => $request->code
        ]);

        return redirect()->back()->with('success', 'Color Create Successfully.');
    }

    public function edit($id)
    {
        $color = Color::where('id', $id)->first();
        return view('Admin.Color.edit', compact('color'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|unique:colors,code,' . $id,
        ]);

        $category = Color::findOrFail($id);

        $category->name = $request->name;
        $category->code = $request->code;
        $category->save();

        return redirect()->route('admin.color')->with('success', 'Color updated successfully.');
    }

    public function delete($id)
    {
        Color::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Color deleted successfully.');
    }
}
