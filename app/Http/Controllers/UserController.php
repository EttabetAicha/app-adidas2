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

    public function resetPassword($token)
    {
        $token1 = session('token_reset');
        if ($token == $token1) {
            return view('auth.resetPass');
        }
    }

    public function resetMyPassword(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required',
        ]);
        $password = Hash::make($validatedData['password']);
        User::where('email', session('email_reset'))->update([
            'password' => $password,
        ]);
        return view("auth.login");
    }
}
