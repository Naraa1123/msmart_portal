<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Procedure;
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

    public function procedure($id)
    {
        $decrypted_id = decrypt($id);
        $procedure = Procedure::find($decrypted_id);
        return view('teacher.juram.index', compact('procedure'));
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
