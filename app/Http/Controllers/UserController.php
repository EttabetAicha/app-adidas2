<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('users', compact('users'));
    }

    public function indexUser()
    {
        $categories = Category::latest()->limit(4)->get();
        $products = Products::latest()->limit(4)->get();
        return view("user.index", compact('products', 'categories'));
    }

    public function getAllProduct()
    {
        $categories = Category::latest()->get();
        $products = Products::latest()->paginate(9);
        return view("user.allItems", compact('products', 'categories'));
    }

    

 

   
}
