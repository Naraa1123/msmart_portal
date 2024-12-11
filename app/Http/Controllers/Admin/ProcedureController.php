<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Procedure;
use App\Models\SpecialNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProcedureController extends Controller
{
    public function index()
    {
        $procedures = Procedure::all();

        return view('admin.procedure.index', compact('procedures'));
    }

    public function create(){
        return view('admin.procedure.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'pdf' => 'sometimes|file|max:20480',
        ]);

        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/pdf/', $filename);
            $validatedData['pdf'] = 'uploads/pdf/' . $filename;
        } else {
            $validatedData['pdf'] = null;
        }

        $specialNews = new Procedure();
        $specialNews->title=$validatedData['title'];
        $specialNews->pdf = $validatedData['pdf'];
        $specialNews->save();

        return redirect()->route('admin.procedure')->with('success','Амжилттай нэмэгдлээ');
    }

    public function edit($id)
    {
        $procedure = Procedure::query()->find($id);

        return view('admin.procedure.edit', compact('procedure'));
    }

    public function update(Request $request,$id)
    {
        $procedure = Procedure::findOrFail($id);
        $validatedData = $request->validate([
            'title' => 'required|string',
            'pdf' => 'nullable|file',
        ]);

        if ($request->hasFile('pdf')) {
            if(File::exists($procedure->pdf)) {
                File::delete($procedure->pdf);
            }
            $file = $request->file('pdf');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/pdf/', $filename);
            $validatedData['pdf'] = 'uploads/pdf/' . $filename;
        } else {
            $validatedData['pdf'] = $procedure->pdf;
        }

        $procedure->update([
            'title' => $validatedData['title'],
            'pdf' => $validatedData['pdf']
        ]);


        return redirect()->route('admin.procedure')->with('message', 'Амжилттай шинэчлэгдлээ');
    }

    public function destroy($id){
        $procedure=Procedure::findorFail($id);
        if(File::exists($procedure->pdf)) {
            File::delete($procedure->pdf);
        }
        $procedure->delete();
        return redirect()->route('admin.procedure')->with('message', 'Амжилттай устгалаа');
    }

}
