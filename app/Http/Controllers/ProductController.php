<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(Request $request)
    { 
        $search = $request->input('search', '');
        $products = Products::simplePaginate(2);
        return view('products.index',compact('search'))->with('products', $products);
    }
    

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'images' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $input = $request->all();
    
       
    if ($request->hasFile('images')) {
        $imageName = $request->file('images')->getClientOriginalName();
        $request->file('images')->move(public_path('assets'), $imageName);
        $input['images'] =  $imageName;
    }
    
        Products::create($input);
    
        return redirect('products')->with('flash_message', 'Product added!');
    }

    public function show($id)
    {
        $product = Products::find($id);
        return view('products.show')->with('product', $product);
    }

    public function edit($id)
    {
        $product = Products::find($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Products::find($id);
        $input = $request->all();
        $product->update($input);
        return redirect('products')->with('flash_message', 'Product updated!');
    }

    public function destroy($id)
    {
        Products::destroy($id);
        return redirect('products')->with('flash_message', 'Product deleted!');
    }
    public function searchProduct(Request $request)
    {
        $search = $request->input('search');
        if ($search == "AllProductSearch") {
            $products = Products::paginate(9);
        } else {
            $products = Products::where('product_name', 'like', "%$search%")->get();
        }
        return view("products.search", compact('products'));
    }
    

    public function filterProduct($search)
    {
        if ($search == "All") {
            $products = Products::paginate(9);
        } else {
            $products = Products::where('category_id', $search)->get();
        }
        return view("user.search", compact('products'));
    }

    public function searchProductPrice($search)
    {
        $price = explode('-', $search);
        $products = Products::where('price', '>', $price[0])->where('price', '<', $price[1])->get();
        return view("user.search", compact('products'));
    }
}