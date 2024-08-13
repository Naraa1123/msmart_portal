<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('admin.department.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.department.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required|string|unique:departments',
            'abbreviation' => 'required|string|unique:departments',
            'status' => 'nullable',
        ]);

        Department::create([
            'name' => $request->input('name'),
            'abbreviation' => $request->input('abbreviation'),
            'status' => $request->status == true ? '1' : '0',
        ]);

        return redirect('admin/department')->with('message', 'Department created successfully');
    }

    public function edit($id)
    {
        $decryptedId = decrypt($id);
        $dep = Department::findOrFail($decryptedId);
        return view('admin.department.edit', compact('dep'));
    }

    public function update(Request $request, $id)
    {
        $dep = Department::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|unique:departments,name,'.$id,
            'abbreviation' => 'required|string|unique:departments,abbreviation,'.$id,
            'status' => 'nullable',
        ]);

        $dep->update([
            'name' => $validatedData['name'],
            'abbreviation' => $validatedData['abbreviation'],
            'status' => $request->status == true ? '1' : '0',
        ]);

        return redirect('admin/department')->with('message', 'Department updated successfully');
    }

    public function destroy($id)
    {
        $dep = Department::findOrFail($id);
        $dep->delete();
        return redirect('admin/department')->with('message', 'Department deleted successfully');
    }



}
