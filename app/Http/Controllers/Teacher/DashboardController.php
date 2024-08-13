<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\SurveyClass;
use App\Models\SurveyResponse;
use App\Models\TeacherNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacherNews = TeacherNews::orderBy('created_at', 'desc')->get();
        return view('teacher.dashboard', compact('teacherNews'));
    }

    public function juram1()
    {
        return view('teacher.juram.juram1');
    }

    public function juram2()
    {
        return view('teacher.juram.juram2');
    }

    public function juram3()
    {
        return view('teacher.juram.juram3');
    }

    public function juram4()
    {
        return view('teacher.juram.juram4');
    }

    public function juram5()
    {
        return view('teacher.juram.juram5');
    }

    public function survey()
    {
        if (Auth::check()) {
            if (Auth::user()->role_as == 2) {
                $user = Auth::user();
                $survey = Survey::where('type', 'teacher')->first();
                if (!empty($survey))
                {
                    $hasDid=SurveyResponse::where('survey_id',$survey->id)
                        ->where('user_id',$user->id)
                        ->first();
                    if (empty($hasDid))
                    {
                        return view('teacher.survey',compact('survey'));
                    }
                    else{
                        return redirect()->route('teacher.dashboard')->with('error','Та судалгаа бөглөсөн байна.');
                    }
                }
                else{
                    return redirect()->route('teacher.dashboard')->with('error','Одоогоор судалгаа байхгүй байна!');
                }

                return view('student.survey', compact('survey'));
            } else {
                return view('auth.login')->with('Та багшын эрхээр нэвтэрнэ үү!');
            }
        } else {
            return view('auth.login');
        }
    }
}
