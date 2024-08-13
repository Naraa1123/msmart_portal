<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = User::findOrFail(Auth::user()->id);

        return view('student.profile', compact('user'));
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
        return redirect('student/dashboard')->with('message', 'Password амжилттай солигдлоо');
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $userDetail = $user->userDetails;

        $validatedData = $request->validate([
            'email' => [
                'nullable',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'image' => 'nullable|image',
            'phone_number_2' => 'nullable|integer|digits:8',
            'date_of_birth' => 'nullable|date_format:Y-m-d',
        ]);

        User::where('id', $user->id)->update([
            'email' => $validatedData['email'],
        ]);

        if($request->hasFile('image')){

            $destination = $userDetail->image;

            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/user/', $filename);
            $validatedData['image'] = 'uploads/user/' . $filename;
        }

        UserDetail::where('id', $userDetail->id)->update([
            'image' => $validatedData['image'] ?? $userDetail->image,
            'phone_number_2' => $validatedData['phone_number_2'],
            'date_of_birth' => $validatedData['date_of_birth'],
        ]);


        return redirect('student/dashboard')->with('message', 'Таны мэдээлэл амжилттай шинэчлэгдлээ');
    }
}
