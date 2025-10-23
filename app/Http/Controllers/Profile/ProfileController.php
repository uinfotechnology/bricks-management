<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Profile
    public function profile()
    {
        $user = User::first();
        return view('admin.pages.profile.view', compact('user'));
    }

    // Update Profile
    public function UpdateProfile(Request $request)
    {
        $request->validate([
            'user_id'          => 'required',
            'name'             => 'required',
            'email'            => 'required|email',
            'old_password'     => 'required',
            'new_password'     => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = User::find(Auth::guard('web')->user()->id);

        if (!$user || !Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('error', 'Old password does not match.');
        }

        $user->user_id = $request->user_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->new_password);
        $user->normal_password = $request->new_password;
        $user->save();

        return redirect()->back()->with('success', 'Your password has been updated successfully.');
    }
}
