<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Mail\PasswordResetEmail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $token = Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
        $email = $request->email;

        $resetUrl = url(route('password.reset', [
            'token' => $token,
            'email' => $email,
        ]));

        Mail::to($email)->send(new PasswordResetEmail($resetUrl));
        return back()->with('success', 'Email Reset Password Anda telah terkirim!');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset', ['token' => $token, 'email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:5|confirmed',
            'password_confirmation' => 'required'
        ]);

        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$tokenData) {
            // Token not found in password_resets table
            return back()->withErrors(['email' => ['Invalid token or email']]);
        } else{
            User::where('email', $request->email)->update([
               'password' => Hash::make($request->password)
            ]);

            DB::table('password_resets')->where([
                'email' => $request->email
            ])->delete();
        }
        return redirect()->route('login')->with('success', 'Password Anda telah diubah! Anda bisa login ulang dengan password baru!');
    }
}
