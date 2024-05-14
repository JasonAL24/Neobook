<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    public function showRegistrationForm()
    {
        return view('users.register', [
            "title" => "Register User"
        ]);
    }

    public function showLoginForm()
    {
        return view('users.login', [
            "title" => "Login User"
        ]);
    }

    public function register(Request $request)
    {
        // Validate registration data
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|unique:users',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = new User();
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        // Create new member
        $member = new Member();
        $member->name = $request->input('nama');
        $member->phone = $request->input('phone');

        $member->user_id = $user->id;
        $member->save();

        // Redirect or return response
        return redirect()->route('login')->with('success', 'Sukses! Anda berhasil masuk!');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/home');
        }

        return redirect()->back()->withErrors(['email' => 'Email/Password yang Anda masukkan salah.'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($id), // Ensure email is unique except for the current user
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $member = Member::findOrFail($id);
        $user = $member->user;

        $member->name = $request->input('name');
        $member->address = $request->input('address');
        $member->phone = $request->input('phone');
        $member->save();

        $user->email = $request->input('email');
        $user->save();

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateProfilePicture(Request $request)
    {
        try {
            $request->validate([
                'profile_picture' => 'required|image|mimes:png|max:2048',
            ]);

            $member = auth()->user()->member;
            $id = $member->id;

            $existingProfilePicture = $member->profile_picture;
            if ($existingProfilePicture) {
                $filePath = "/img/profile/$id/$existingProfilePicture";
                Storage::delete($filePath);
            }

            $profilePicture = $request->file('profile_picture');
            $fileName = time() . '.' . $profilePicture->getClientOriginalExtension();

            $directory = "/img/profile/$id";
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            $profilePicture->move(public_path($directory), $fileName);

            $member->profile_picture = $fileName;
            $member->save();

            return redirect()->back()->with('success', 'Gambar profil anda berhasil diperbarui.');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }
}
