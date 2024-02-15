<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    // Submit email for password reset
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        // If user not found, return with error
        if (!$user) {
            return redirect()->back()->withErrors(['email' => 'User not found']);
        }

        // Generate unique token
        $token = md5(uniqid(rand(), true)); 

        // Update user's password reset token
        $user->update(['password_reset_token' => $token]);

        // Send password reset email
        Mail::to($user->email)->send(new ResetPasswordMail($user));

        return redirect()->back()->with('success', 'Password reset link sent to your email.');
    }

    // Process password reset
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'token' => 'required',
        ]);

        // Find user by email and password reset token
        $user = User::where('email', $request->email)
                    ->where('password_reset_token', $request->token)
                    ->first();

        // If user not found or token is invalid, return with error
        if (!$user) {
            return redirect()->back()->withErrors(['token' => 'Invalid token']);
        }

        // Update user's password and reset token
        $user->update([
            'password' => Hash::make($request->password),
            'password_reset_token' => null,
        ]);

        // Redirect to login page with success message
        return redirect('/login')->with('success', 'Password reset successful. Please log in with your new password.');
    }
}
