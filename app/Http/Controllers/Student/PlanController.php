<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ClassSubject;
use App\Models\ClassSubjectTopic;
use App\Models\Department;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;


class PlanController extends Controller
{
    public function index()
    {
        $studentId = Auth::user();
        $classId = User::where('id', $studentId->id)->value('class_id');

        $departmentId=SchoolClass::where('id',$classId)->value('department_id');
        $class_name=Department::where('id',$departmentId)->value('name');

        $classSubject=ClassSubject::where('class_id',$classId)->get();

        $events = [];

        foreach ($classSubject as $subject) {
            $topics = ClassSubjectTopic::where('class_subject_id', $subject->id)->get();

            foreach ($topics as $topic) {
                $class_subject = ClassSubject::where('id', $topic->class_subject_id)->first();
                $subject_name=Subject::where('id',$class_subject->subject_id)->first();
                $event = [
                    'id' => $topic->id,
                    'subject' => $subject_name->name,
                    'title' => $topic->topic,
                    'start' => (new DateTime($topic->date_of_topic . ' ' . $topic->start_time))->format('Y-m-d\TH:i:s'),
                    'description' => $topic->homework,
                ];

                $events[] = $event;
            }

        }

        return view('student/plan', compact('events','class_name'));
    }
}
