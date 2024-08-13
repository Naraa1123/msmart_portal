<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassSubject;
use App\Models\ClassSubjectTopic;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\TeacherClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Object_;
use DateTime;

class ClassSubjectTopicController extends Controller
{
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'class_subject_id' => 'required',
            'topic' => 'required',
            'homework' => 'nullable',
            'date_of_topic' => 'required',
        ]);

        if ($request->has('homework') && $request->homework !== null) {
            $validatedData['homework'] = preg_replace('/\s+/', ' ', $validatedData['homework']);
        }

        ClassSubjectTopic::create($validatedData);

        return redirect()->back()->with('success', 'Амжилттай нэмэгдлээ');
    }

    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'class_topic_id'=>'required',
            'class_subject_id' => 'required',
            'topic' => 'required',
            'homework' => 'nullable',
            'date_of_topic' => 'required',
        ]);

        $classSubjectTopic = ClassSubjectTopic::findOrFail($validatedData['class_topic_id']);

        $classSubjectTopic->update([
            'class_subject_id' => $validatedData['class_subject_id'],
            'topic' => $validatedData['topic'],
            'date_of_topic' => $validatedData['date_of_topic'],
            'homework' => $validatedData['homework'],
        ]);

        return redirect()->back()->with('success', 'Амжилттай засварлалаа');
    }

    public function see(){
        $teacher = Auth::user();

        $teacherClasses = TeacherClass::where('user_id', $teacher->id)
            ->orderByDesc('class_id')
            ->get();

        $classes = [];

        foreach ($teacherClasses as $teacherClass) {
            $class = SchoolClass::find($teacherClass->class_id);

            if ($class) {
                $classes[] = $class;
            }
        }

        return view('teacher/plan/see', compact('classes'));
    }

    public function all($id,$class_name)
    {
        $classSubject = ClassSubject::where('class_id', $id)->get();
        $data['getObject'] = ClassSubject::where('class_id', $id)->get();
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
                $event = [
                    'id' => $topic->id,
                    'subject' => $class_subject->id,
                    'title' => $topic->topic,
                    'start' => (new DateTime($topic->date_of_topic . ' ' . $topic->start_time))->format('Y-m-d\TH:i:s'),
                    'description' => $topic->homework,
                ];

                $events[] = $event;
            }
        }

        return view('teacher/plan/all', compact('plans', 'events', 'class_name', 'data'));
    }


    public function destroy($id)
    {
        $classSubjectTopic = ClassSubjectTopic::findOrFail($id);
        $classSubjectTopic->delete();
        return redirect()->back()->with('success', 'Амжилттай устгагдлаа');
    }


}
