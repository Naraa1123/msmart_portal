<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\SurveyResponse;
use App\Models\SurveyRespondents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyResponseController extends Controller
{
    public function submit(Request $request, $id)
    {
        $validatedData = $request->validate([
            'answers.*' => 'nullable',
        ]);

        $userId = auth()->id();

        if(isset($validatedData['answers'])) {

            foreach ($validatedData['answers'] as $questionId => $answers) {
                if(is_array($answers)) {

                    foreach ($answers as $answer) {

                        SurveyResponse::create([
                            'user_id' => $userId,
                            'survey_id' => $id,
                            'question_id' => $questionId,
                            'answer' => $answer,
                        ]);
                    }
                } else {
                    SurveyResponse::create([
                        'user_id' => $userId,
                        'survey_id' => $id,
                        'question_id' => $questionId,
                        'answer' => $answers,
                    ]);
                }
            }
            SurveyRespondents::create([
                'user_id'=>$userId,
                'survey_id'=>$id,
            ]);
        }

        if (Auth::user()->role_as == 2)
        {
            return redirect()->route('teacher.dashboard')->with('success', 'Survey submitted successfully!');
        }
        else{
            return redirect()->route('student.grade')->with('success', 'Survey submitted successfully!');
        }

    }

    public function report(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|String',
            'description' => 'required|String',
        ]);
        $teacher_id = Auth::user()->id;
        Report::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'teacher_id' => $teacher_id,
            'student_id' => $id,
        ]);
        return redirect()->back()->with('success', 'Амжилттай!');
    }

    public function students()
    {
        $teacher_id = Auth::user()->id;
        $students = Report::query()->where('teacher_id',$teacher_id)->get();
        return view('teacher.reports',compact('students'));
    }

}
