<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::query()
            ->where('status', 'холбогдоогүй')
            ->whereHas('student.userDetails', function ($query) {
                $query->where('status', 'studying');
            })
            ->get();

        return view('admin.report.index',compact('reports'));
    }

    public function update(Request $request,$id)
    {
        $validatedData = $request->validate([
            'feedback'=>'nullable'
        ]);

        $report = Report::query()->findOrFail($id);

        $report->update([
            'feedback' => $validatedData['feedback'],
            'status' => 'холбогдсон',
        ]);

        return redirect()->back()->with('success','Амжилттай!');
    }

    public function contact()
    {
        $reports = Report::query()->where('status','холбогдсон')->get();

        return view('admin.report.contacted',compact('reports'));
    }

}
