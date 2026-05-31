<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show', ['user' => Auth::user()]);
    }

    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'address' => 'nullable|string|max:500',
            'gender'  => 'nullable|in:Male,Female,Other',
            'phone'   => 'nullable|string|max:20',
        ]);

        $data = $request->only('name', 'email', 'address', 'gender', 'phone');

        if ($request->filled('password')) {
            $request->validate([
                'password'              => 'min:6|confirmed',
                'current_password'      => 'required',
            ]);
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            $request->validate(['profile_picture' => 'image|mimes:jpg,jpeg,png,gif|max:2048']);

            // Delete old picture if exists
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $data['profile_picture'] = $path;
        }

        $user->update($data);

        return redirect()->route('profile.show')
            ->with('toast_success', 'Profile updated successfully.');
    }
}
