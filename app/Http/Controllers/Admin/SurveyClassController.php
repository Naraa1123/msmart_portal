<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Survey;
use App\Models\SurveyClass;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SurveyClassController extends Controller
{
    public function index()
    {
        $survey_class = SurveyClass::orderBy('created_at', 'DESC')->get();
        $surveys = Survey::all();
        $classes = SchoolClass::where('status', '0')->get()
            ->sort(function($a, $b) {
                return substr($a->name, 0, 2) <=> substr($b->name, 0, 2);
            });

        return view('admin.survey.survey_class', compact('survey_class','surveys','classes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'survey_id' => 'required|exists:surveys,id',
            'class_id' => 'required|exists:classes,id'
        ]);

        try {
            $surveyClass = new SurveyClass;
            $surveyClass->survey_id = $validatedData['survey_id'];
            $surveyClass->class_id = $validatedData['class_id'];
            $surveyClass->save();

            return redirect()->back()->with('message','Амжилттай Холбогдлоо');
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->with('message','Аль хэдийн холбогдсон байна');
            } else {
                return redirect()->back()->with('message','Chinku-д хэлдээ ахах');
            }
        }

    }

    public function destroy($id)
    {
        $decryptedId = decrypt($id);
        $survey_class = SurveyClass::findOrFail($decryptedId);

        if($survey_class)
        {
            $survey_class->delete();
            return redirect()->back()->with('message', 'Connection deleted successfully');
        }
        else
        {
            return redirect()->back()->with('error','Something Went Wrong');
        }
    }
}
