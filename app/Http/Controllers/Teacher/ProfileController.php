<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = User::findOrFail(Auth::user()->id);

        return view('teacher.profile', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Get the user by ID
        $user = User::findOrFail($id);

        // Check if the old password matches the current password
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'The current password is incorrect'])->withInput();
        }

        // Update the password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Redirect with success message
        return redirect('teacher/dashboard')->with('message', 'Password амжилттай солигдлоо');
    }
}
