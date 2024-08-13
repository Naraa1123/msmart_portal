<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::orderBy("created_at", 'desc')->get();
        $departments = Subject::whereNotNull('department')->distinct()->pluck('department');
        return view('admin.subject.index', compact('subjects', 'departments'));
    }

    public function create()
    {
        return view('admin.subject.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'department' => 'required',
            'name' => 'required|string|max:255',
            'status' => 'nullable'
        ]);

        Subject::create([
            'name' => $validatedData['name'],
            'department' => $validatedData['department'],
            'status' => $request->status == true ? '1' : '0',
        ]);

        return redirect('admin/subject')->with('message', 'Хичээл амжилттай бүртгэгдлээ');

    }

    public function edit($id)
    {
        $decryptedId = decrypt($id);
        $departments = Department::all();
        $subject = Subject::findOrFail($decryptedId);
        return view('admin.subject.edit', compact('subject', 'departments'));
    }

    public function update(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $validatedData = $request->validate([
            'department' => 'required',
            'name' => 'required|string|max:255',
            'status' => 'nullable'
        ]);
        $subject->department = $validatedData['department'];
        $subject->name = $validatedData['name'];
        $subject->status = $request->has('status') ? 1 : 0;

        $subject->save();

        return redirect('admin/subject')->with('message', 'Subject updated successfully');
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return redirect('admin/subject')->with('message', 'Subject deleted successfully');
    }
}
