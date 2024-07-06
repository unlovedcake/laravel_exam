<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // public function index()
    // {
    //     $products = Product::whereHas('category', function ($query) {
    //         $query->where('name', 'Paint');
    //     })->get();

    //     return view('product.index', compact('products'));
    // }

    public function index(Request $request)
    {

        $categoryName =  $request->category_name;
        $categories = Category::all();
        $categoryId = $request->input('category_id');


        if ($categoryId) {



            $products = Product::whereHas('category', function ($query) use ($categoryId) {
                $query->where('id', $categoryId);
            })->get();
        } else {

            $products = Product::with('category')->get();
        }




        return view('product.index', compact(['products', 'categories']));
    }

    public function create()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image,
            'category_name' => $request->category_name,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('product.create')->with('success', 'Product added successfully!');
    }

    public function filter()
    {
        $filterProducts = Product::whereHas('category', function ($query) {
            $query->where('name', 'Paint');
        })->get();

        return view('product.create', compact('products'));
    }
}
