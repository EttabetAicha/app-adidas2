<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail1;
use App\Models\Password_reset_token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    public function displayform()
    {
        // $token = Password_reset_token::where('token', $token)->first();

        return view('auth.rest');
        // }
        // else{
        //     abort(403);
        // }

    }
    public function changepswrd(string $token)
    {
        $token = Password_reset_token::where('token', $token)->first();
        if ($token) {
            return view('auth.newpswrd', compact('token'));
        } else {
            abort(403);
        }
    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'User not found']);
        }
        $token = md5(uniqid(rand(), true));
        $find = Password_reset_token::where('email', $user->email)->first();
        if (!$find) {
            Password_reset_token::create([
                'email' => $user->email,
                'token' => $token,
                'created_at' => now(),
            ]);
        } else {
            $find->where('email', $user->email)->update([
                'token' => $token,
            ]);
        }
        $users = User::select('name')->first();
        // dd($users);
        Mail::to($user->email)->send(new ResetPasswordMail1($token,$users));

        return redirect()->back()->with('success', 'Password reset link sent to your email.');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
        ]);

        $user = Password_reset_token::where('token', $request->token)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['token' => 'Invalid token']);
        }
        $email = $user['email'];
        User::where('email', $email)->first()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Password reset successful. Please log in with your new password.');
    }
}
