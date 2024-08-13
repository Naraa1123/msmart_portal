<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Models\WebSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class WebSettingController extends Controller
{
    public function edit_setting($id)
    {
        $web = WebSetting::findOrFail($id);
        return view('admin.web.setting', compact('web'));
    }

    public function setting_update(Request $request,$id)
    {
        $web = WebSetting::findOrFail($id);

        $validatedData = $request->validate([
            'web_name' => 'required|string',
            'address' => 'required|string',
            'web_logo' => 'nullable',
            'email' => 'required|email',
            'phone_number' => 'required|numeric',
            'account_number' => 'nullable',
            'account_name' => 'nullable',
            'google_map_link' => 'nullable',
            'facebook_link' => 'nullable',
            'instagram_link' => 'nullable',
            'youtube_link' => 'nullable',
        ]);

        if($request->hasFile('web_logo')){
            $destination = $web->web_logo;
            if(File::exists($destination)){
                File::delete($destination);
            }

            $file = $request->file('web_logo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/web_data_setting/',$filename);
            $validatedData['web_logo'] = 'uploads/web_data_setting/'.$filename;
        }

        WebSetting::where('id', 'd03a7f43-f1e3-47b0-8a61-21e79df08c7f')->update([
            'web_name' => $validatedData['web_name'],
            'address' => $validatedData['address'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'account_number' => $validatedData['account_number'],
            'account_name' => $validatedData['account_name'],
            'web_logo' => $validatedData['web_logo'] ?? $web->web_logo,

            'google_map_link' => $validatedData['google_map_link'],
            'facebook_link' => $validatedData['facebook_link'],
            'instagram_link' => $validatedData['instagram_link'],
            'youtube_link' => $validatedData['youtube_link'],
        ]);

        return redirect('admin/dashboard')->with('message', 'Site information updated successfully');
    }

}
