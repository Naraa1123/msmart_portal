<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecialNews;
use App\Models\SpecialNewsImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SpecialNewsController extends Controller
{
    public function index()
    {
        $specialNews=SpecialNews::All();
        return view('admin.news.special.index',compact('specialNews'));
    }
    public function create()
    {
        return view('admin.news.special.create');
    }
    public function addNews(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required',
            'yt_link'=>'nullable',
            'pdf' => 'sometimes|file|max:20480',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);

        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/news/special/pdf/', $filename);
            $validatedData['pdf'] = 'uploads/news/special/pdf/' . $filename;
        } else {
            $validatedData['pdf'] = null;
        }

        $specialNews = new SpecialNews();
        $specialNews->title=$validatedData['title'];
        $specialNews->description=$validatedData['description'];
        $specialNews->yt_link=$validatedData['yt_link'];
        $specialNews->pdf = $validatedData['pdf'];
        $specialNews->save();

        if ($request->hasFile('images'))
        {
            foreach ($request->file('images') as $image) {
                $imageFilename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/news/special'), $imageFilename);
                // Assuming you have a related model for storing image paths
                $specialNews->images()->create([
                    'path' => 'uploads/news/special/' . $imageFilename,
                ]);
            }
        }
        return redirect()->route('admin.special.news')->with('success','Амжилттай нэмэгдлээ');
    }

    public function deleteNews($id){
        $studentNews=SpecialNews::findorFail($id);
        if(File::exists($studentNews->pdf)) {
            File::delete($studentNews->pdf);
        }
        $studentNews->delete();
        return redirect()->route('admin.special.news')->with('message', 'Амжилттай устгалаа');
    }

    public function editNews($id)
    {
        $specialNews=SpecialNews::findorFail($id);
        return view('admin.news.special.edit',compact('specialNews'));
    }

    public function updateNews(Request $request,$id)
    {
        $studentNews = SpecialNews::findOrFail($id);
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required',
            'yt_link'=>'nullable',
            'pdf' => 'nullable|file',
             'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480',
        ]);

        if ($request->hasFile('pdf')) {
            if(File::exists($studentNews->pdf)) {
                File::delete($studentNews->pdf);
            }
            $file = $request->file('pdf');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/news/special/pdf/', $filename);
            $validatedData['pdf'] = 'uploads/news/special/pdf/' . $filename;
        } else {
            $validatedData['pdf'] = null;
        }

        $studentNews->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'yt_link'=>$validatedData['yt_link'],
            'pdf' => $validatedData['pdf']
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageFilename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/news/special'), $imageFilename);

                $studentNews->images()->create([
                    'path' => 'uploads/news/special/' . $imageFilename,
                ]);
            }
        }

        return redirect()->route('admin.special.news')->with('message', 'News updated successfully');
    }

    public function deleteImage($id)
    {
        $image = SpecialNewsImage::findOrFail($id);
        $filePath = public_path($image->path);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        $image->delete();

        return response()->json(['success' => true]);
    }

}
