<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StudentNews;
use Illuminate\Http\Request;

class StudentNewsController extends Controller
{
    public function index()
    {
        $studentNews=StudentNews::All();
        return view('admin.news.student.index',compact('studentNews'));
    }

    public function create()
    {
        return view('admin.news.student.create');
    }
    public function addNews(Request $request)
    {
        $studentNews = new StudentNews();
        $studentNews->title=$request->input('title');
        $studentNews->description=$request->input('description');
        $studentNews->save();
        return redirect('admin/student/news');
    }

    public function deleteNews($id){
        $studentNews=StudentNews::findorFail($id);
        $studentNews->delete();
        return redirect('admin/student/news')->with('message', 'Department deleted successfully');

    }

    public function editNews($id)
    {
        $studentNews=StudentNews::findorFail($id);
        return view('admin.news.student.edit',compact('studentNews'));
    }

    public function updateNews(Request $request,$id)
    {

        $studentNews = StudentNews::findOrFail($id);


        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required',
        ]);

        $studentNews->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
        ]);

        return redirect('admin/student/news')->with('message', 'News updated successfully');
    }
    public function uploadImage(Request $request)
    {
        if($request->hasFile('upload'))
        {
            $originName=$request->file('upload')->getClientOriginalName();
            $fileName=pathinfo($originName,PATHINFO_FILENAME);
            $extension=$request->file('upload')->getClientOriginalExtension();
            $fileName=$fileName.'_'.time().'.'.$extension;
            $request->file('upload')->move('uploads/news/', $fileName);
            $url=asset('uploads/news/'.$fileName);
            return response()->json(['filename'=>$fileName,'uploaded'=>1,'url'=>$url]);
        }
    }
}
