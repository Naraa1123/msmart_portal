<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSubject;
use App\Models\ClassSubjectTopic;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;
use DateTime;
use App\Models\Department;

class ClassPlanController extends Controller
{
    public function index()
    {
        $departmentIds = Department::pluck('id')->toArray();
        $classPlans = [];

        foreach ($departmentIds as $departmentId) {
            $classPlans["department_$departmentId"] = SchoolClass::where('department_id', $departmentId)
                ->orderBy('name', 'asc')
                ->get();
        }

        return view('admin.class_plan.index', compact('classPlans'));
    }

    public function check($id,$class_name)
    {
        $decryptedId=decrypt($id);

        $classSubject = ClassSubject::where('class_id', $decryptedId)->get();

        $data['getObject'] = ClassSubject::where('class_id', $decryptedId)->get();
        $plans = [];

        foreach ($classSubject as $subj) {
            $plan = ClassSubjectTopic::where('class_subject_id', $subj->id)->get();
            foreach ($plan as $p) {
                if ($p) {
                    $plans[] = $p;
                }
            }

        }

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

        return view('admin.class_plan.check', compact('plans', 'events', 'class_name', 'data'));
    }
}
