<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductColorDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ProductsController extends Controller
{
    public function index()
    {
        return view('Admin.Product.list');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::select('products.*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($row) {
                    $category = Category::where('id', $row->categories_id)->first();
                    return $category->name;
                })
                ->addColumn('status', function ($row) {
                    if($row->status == 1){
                        return '<span class="badge bg-success text-white">Publish</span>';
                    }else if($row->status == 2){
                        return '<span class="badge bg-warning text-white">Pending</span>';
                    }else{
                        return '<span class="badge bg-light text-black">Draft</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.products.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                    $btn .= ' <a href="javascript:void(0);" data-id="' . $row->id . '" class="btn btn-sm btn-danger delete-category">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action', 'status', 'category'])
                ->make(true);
        }
    }

    public function create()
    {
        $category = Category::all();
        $colors = Color::all();
        return view('Admin.Product.create', compact('category', 'colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products,name',
        ], [
            'name.unique' => 'This product name already exists. Please choose another one.',
            'name.required' => 'Please enter the product name.',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->description = $request->description;
        $product->gender = $request->gender;
        $product->categories_id = $request->categories_id;
        $product->colors = json_encode($request->colors);

        $product->save();

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function edit($id)
    {
        $category = Category::all();
        $colors = Color::all();
        $product = Product::with('colorDetails')->findOrFail($id);
        return view('Admin.Product.edit', compact('category', 'colors', 'product'));
    }

    public function update(Request $request, $id)
    {    
        $product = Product::findOrFail($id);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'gender' => $request->gender,
            'categories_id' => $request->categories_id,
            'colors' => json_encode($request->colors),
        ]);

        $prices = $request->prices ?? [];
        $images = $request->file('images') ?? [];

        foreach ($request->colors as $colorId) {

            $colorDetail = ProductColorDetail::where('product_id', $product->id)
                ->where('color_id', $colorId)
                ->first();

            if (!$colorDetail) {
                $colorDetail = new ProductColorDetail();
                $colorDetail->product_id = $product->id;
                $colorDetail->color_id = $colorId;
            }

            $colorDetail->price = $prices[$colorId] ?? 0;

            $uploadedImages = [];
            if (isset($images[$colorId])) {
                foreach ($images[$colorId] as $file) {
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = public_path('products/color_images/' . $colorId);

                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }

                    $file->move($path, $filename);
                    $uploadedImages[] = 'products/color_images/' . $colorId . '/' . $filename;
                }
            }

            if ($colorDetail->images) {
                $oldImages = json_decode($colorDetail->images, true) ?? [];
                $uploadedImages = array_merge($oldImages, $uploadedImages);
            }

            $colorDetail->images = json_encode($uploadedImages);
            $colorDetail->save();
        }

        return redirect()->back()
            ->with('success', 'Product updated successfully!');
    }

    public function delete($id){
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->back()
            ->with('success', 'Product deleted successfully!');
    }

}
