<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\SpecialNews;
use App\Models\StudentNews;
use App\Models\SubjectGrade;
use App\Models\Survey;
use App\Models\SurveyClass;
use App\Models\SurveyRespondents;
use App\Models\SurveyResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    public function index()
    {
        return view('student.dashboard');
    }

    public function durem()
    {
        return view('student.durem');
    }

    public function tulbur()
    {
        $user = User::findOrFail(Auth::user()->id);
        return view('student.payment', compact('user'));
    }

    public function news()
    {
        $studentNews = StudentNews::orderBy('created_at', 'desc')->get();
        return view('student.news', compact('studentNews'));
    }

    public function survey()
    {
        if (Auth::check()) {
            if (Auth::user()->role_as == 3) {
                $user = Auth::user();
                $surveyClasses = SurveyClass::where('class_id', $user->class_id)->get();
                if (!empty($surveyClasses)) {
                    foreach ($surveyClasses as $surveyClass) {
                        $hasDid = SurveyRespondents::where('user_id', $user->id)
                            ->where('survey_id', $surveyClass->survey_id)
                            ->first();
                        if (empty($hasDid)) {
                            $survey = Survey::where('id', $surveyClass->survey_id)
                                ->where('type', 'student')
                                ->first();
                            return view('student.survey', compact('survey'));
                        }
                    }
                    return redirect()->route('student.grade');
                } else {
                    return redirect()->route('student.grade');
                }
            } else {
                return view('auth.login')->with('Та сурагчын эрхээр нэвтэрнэ үү!');
            }
        } else {
            return view('auth.login');
        }
    }

    public function grade()
    {
        $decryptId = Auth::user()->id;

        $user = User::with('class.subjects')->find($decryptId);

        if (!$user || !$user->class) {
            return redirect('student/grade')->with('error', 'User or class not found.');
        }


        $subjects = $user->class->subjects;

        $grades = SubjectGrade::where('user_id', $decryptId)
            ->get()
            ->keyBy('subject_id');


        $subjectsWithGrades = $subjects->map(function ($classSubject) use ($grades) {
            $subjectId = $classSubject->subject_id;
            $grade = $grades->get($subjectId);

            return [
                'subject' => $classSubject->subject,
                'grade' => $grade ? $grade->grade : 'No Grade'
            ];
        });

//        dd($subjectsWithGrades);

        return view('student.grade', compact('subjectsWithGrades', 'user'));
    }

    public function special()
    {
        $specialNews = SpecialNews::orderBy('created_at', 'desc')->get();
        return view('student.special_news', compact('specialNews'));
    }
}
