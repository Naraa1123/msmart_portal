<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::query()->where('status','холбогдоогүй')->get();

        return view('admin.report.index',compact('reports'));
    }

    public function update($id)
    {
        $report = Report::query()->findOrFail($id);

        $report->update([
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
