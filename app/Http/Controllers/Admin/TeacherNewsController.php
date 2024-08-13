<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherNews;
use Illuminate\Http\Request;

class TeacherNewsController extends Controller
{
    public function index()
    {
        $teacherNews=TeacherNews::All();
        return view('admin.news.teacher.index',compact('teacherNews'));
    }

    public function create()
    {
        return view('admin.news.teacher.create');
    }
    public function addNews(Request $request)
    {
        $teacherNews=new TeacherNews();
        $teacherNews->title=$request->input('title');
        $teacherNews->description=$request->input('description');
        $teacherNews->save();
        return redirect('admin/teacher/news');
    }

    public function deleteNews($id){
        $teacherNews=TeacherNews::findorFail($id);
        $teacherNews->delete();
        return redirect('admin/teacher/news')->with('message', 'News deleted successfully');

    }

    public function editNews($id)
    {
        $teacherNews=TeacherNews::findorFail($id);
        return view('admin.news.teacher.edit',compact('teacherNews'));
    }

    public function updateNews(Request $request,$id)
    {
        $teacherNews = TeacherNews::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required',
        ]);

        $teacherNews->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
        ]);

        return redirect('admin/teacher/news')->with('message', 'News updated successfully');
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
