<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role_id' => 2,
        ]);
        return redirect('/login')->with('success', 'Registration successful. Please log in.');
    }
    public function login(Request $request)
    {
        $validateData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $validateData['email'])->first();
        if ($user) {
            if (password_verify($validateData['password'], $user->password)) {
                session(['username' => $user->name]);
                session(['email' => $user->email]);
                session(['user_id' => $user->id]);
                session(['user_role' => $user->role_id]);
                if ($user->role_id == 1) {
                    return redirect('/dashboard');
                } elseif ($user->role_id == 2) {
                    return redirect('/');
                }
            } else {
                return redirect('/login')->withErrors(['password' => 'Invalid password']);
            }
        }
        return redirect('/login')->withErrors(['email' => 'User not found']);
    }
    public function logout(Request $request)
    {
        Auth::logout();     
        $request->session()->invalidate();
        $request->session()->regenerateToken(); 
    
        return redirect('/login');
    }
}
