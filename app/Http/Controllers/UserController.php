<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categorie;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('users', compact('users'));
    }

    public function userDashboard()
    {
        $categorys = Category::orderBy('created_at', 'desc')->limit(4)->get();
        $products = Products::orderBy('created_at', 'desc')->limit(4)->get();
        return view("user.index", compact('products', 'categorys'));
    }

    public function getAllProduct()
    {
        $categorys = Category::orderBy('created_at', 'desc')->get();
        $products = Products::orderBy('created_at', 'desc')->paginate(9);
        return view("user.allItems", compact('products', 'categorys'));
    }

    public function searchProduct($search)
    {
        if ($search == "AllProductSearch") {
            $products = Products::paginate(9);
        } else {
            $products = Products::where('name', 'like', "%$search%")->get();
        }
        return view("user.search", compact('products'));
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
