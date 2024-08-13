<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Entrant;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class EntrantController extends Controller
{
    public function index()
    {
        Paginator::useBootstrapFive();
        $entrants = Entrant::orderBy('created_at', 'desc')->paginate(5);
        return view('admin.entrant.index', compact('entrants'));
    }

    public function create()
    {
        $deps = Department::where('status','0')->get();;
        return view('admin.entrant.create',compact('deps'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|integer',
            'email' => 'required|email',
            'phone' => 'required|digits:8'
        ]);

        Entrant::create([
            'name' => $validatedData['name'],
            'department_id' => $validatedData['department_id'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
        ]);

        return redirect('admin/entrant')->with('message', 'Элсэх хүсэлт амжилттай бүртгэгдлээ');
    }

    public function edit($id)
    {
        $deps = Department::where('status','0')->get();;
        $entrant = Entrant::findOrFail($id);
        return view('admin.entrant.edit', compact('entrant','deps'));
    }

    public function update(Request $request, $id)
    {
        $entrant = Entrant::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required|integer',
            'email' => 'required|email',
            'phone' => 'required|digits:8'
        ]);

        $entrant->update($validatedData);

        return redirect('admin/entrant')->with('message', 'Entrant updated successfully');
    }

    public function destroy($id)
    {
        $entrant = Entrant::findOrFail($id);
        $entrant->delete();
        return redirect('admin/entrant')->with('message', 'Entrant deleted successfully');
    }

    public function changeStatus($id, $status)
    {
        $entrant = Entrant::findOrFail($id);

        $allowedStatus = ['registered', 'temporary_registration', 'called'];
        if (!in_array($status, $allowedStatus)) {
            return redirect()->back()->with('message', 'Invalid status selected');
        }

        $entrant->update(['status' => $status]);

        return redirect('admin/entrant')->with('message', 'Status changed successfully');
    }


}
