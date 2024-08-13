<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassTimetable;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Week;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class ClassTimetableController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::where('status', '0')->get()
            ->sort(function($a, $b) {
                return substr($a->name, 0, 2) <=> substr($b->name, 0, 2);
            });

        $timetables = ClassTimetable::orderBy('created_at', 'desc');

        return view('admin.timetable.index', compact('timetables','classes'));
    }


    public function getTimeData($id)
    {
        $decryptedId=decrypt($id);
        $weeks = Week::all();
        $class = SchoolClass::findOrFail($decryptedId);
        $timetables = ClassTimetable::where('class_id', $decryptedId)->get()->keyBy('week_id');
        return view('admin.timetable.timetable',compact('weeks','class','timetables'));
    }

    public function create()
    {
        $weeks = Week::all();
        $classes = SchoolClass::where('status', '0')->get()
            ->sort(function($a, $b) {
                return substr($a->name, 0, 2) <=> substr($b->name, 0, 2);
            });
        return view('admin.timetable.create',compact('weeks','classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'start_time' => 'array|required',
            'end_time' => 'array|required',
            'room_number' => 'array|required',
        ]);

        $classId = $request->input('class_id');

        foreach ($request->input('start_time') as $weekId => $startTime) {
            if (!empty($startTime) && !empty($request->input("end_time.$weekId")) && !empty($request->input("room_number.$weekId"))) {
                // Use updateOrCreate method
                ClassTimetable::updateOrCreate(
                    [
                        'class_id' => $classId,
                        'week_id' => $weekId,
                    ],
                    [
                        'start_time' => $startTime,
                        'end_time' => $request->input("end_time.$weekId"),
                        'room_number' => $request->input("room_number.$weekId"),
                    ]
                );
            }
        }

        return redirect()->route('admin.timetable-all')->with('message', 'Timetable updated successfully');
    }

    public function destroy($classId, $weekId)
    {
        $timetableEntry = ClassTimetable::where('class_id', $classId)->where('week_id', $weekId)->first();

        if ($timetableEntry) {
            $timetableEntry->delete();
            return back()->with('message', 'Timetable entry deleted successfully.');
        }

        return back()->with('error', 'Timetable entry not found.');
    }

}
