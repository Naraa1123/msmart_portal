<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Survey;
use App\Models\SurveyClass;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionAnswer;
use App\Models\SurveyRespondents;
use App\Models\SurveyResponse;
use App\Models\User;
use Faker\Provider\en_UG\PhoneNumber;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::all();
        return view('admin.survey.survey', compact('surveys'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'required|string',
            'type' => 'required'
        ]);

        Survey::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'type' => $validatedData['type'],
        ]);

        return redirect()->route('admin.survey.list')->with('message', 'Survey created successfully');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'required|string',
            'type' => 'required'
        ]);

        $survey = Survey::findOrFail($id);
        $survey->update($validatedData);

        return redirect()->route('admin.survey.list')->with('message', 'Survey updated successfully');
    }


    public function destroy($id)
    {
        $decryptedId = decrypt($id);

        $survey = Survey::findOrFail($decryptedId);

        if ($survey) {
            $survey->delete();
            return redirect()->route('admin.survey.list')->with('message', 'Survey deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    public function surveyQuestion($id)
    {
        $decryptedId = decrypt($id);

        $survey = Survey::findOrFail($decryptedId);
        $survey_questions = $survey->questions;

        return view('admin.survey.survey_question', compact('survey', 'survey_questions'));
    }

    public function surveyQuestionStore(Request $request, $id)
    {
        $decryptedId = decrypt($id);
        $survey = Survey::findOrFail($decryptedId);

        $validatedData = $request->validate([
            'question_type' => 'required',
            'question_text' => 'required|string'
        ]);

        if ($survey) {
            SurveyQuestion::create([
                'survey_id' => $survey->id,
                'question_type' => $validatedData['question_type'],
                'question_text' => $validatedData['question_text']
            ]);

            return redirect()->back()->with('message', 'Question created successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went Wrong');
        }

    }

    public function surveyQuestionUpdate(Request $request, $id)
    {
        $decryptedId = decrypt($id);
        $survey = Survey::findOrFail($decryptedId);

        $validatedData = $request->validate([
            'survey_question_id' => 'required|exists:survey_questions,id',
            'question_type' => 'required',
            'question_text' => 'required|string'
        ]);

        $survey_question = SurveyQuestion::findOrFail($validatedData['survey_question_id']);

        if ($survey) {
            $survey_question->update([
                'question_type' => $validatedData['question_type'],
                'question_text' => $validatedData['question_text']
            ]);

            return redirect()->back()->with('message', 'Question Updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    public function surveyQuestionDestroy($id)
    {
        $decryptedId = decrypt($id);
        $survey_question = SurveyQuestion::findOrFail($decryptedId);

        if ($survey_question) {
            $survey_question->delete();
            return redirect()->back()->with('message', 'Question deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went Wrong');
        }

    }

    public function showQuestionOption($id)
    {
        $decryptedId = decrypt($id);

        $question = SurveyQuestion::findOrFail($decryptedId);
        $question_answers = $question->answers;
        return view('admin.survey.option', compact('question_answers', 'question'));
    }

    public function storeQuestionOption(Request $request, $id)
    {
        $decryptedId = decrypt($id);
        $question = SurveyQuestion::findOrFail($decryptedId);

        $validatedData = $request->validate([
            'answer_text' => 'required|string'
        ]);

        if ($question) {
            SurveyQuestionAnswer::create([
                'question_id' => $question->id,
                'answer_text' => $validatedData['answer_text']
            ]);
            return redirect()->back()->with('message', 'Option created successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    public function updateQuestionOption(Request $request, $id)
    {
        $decryptedId = decrypt($id);

        $question = SurveyQuestion::findOrFail($decryptedId);

        $validatedData = $request->validate([
            'option_id' => 'required|exists:survey_question_answers,id',
            'answer_text' => 'required|string'
        ]);

        $option = SurveyQuestionAnswer::findOrFail($validatedData['option_id']);


        if ($question) {
            $option->update([
                'answer_text' => $validatedData['answer_text']
            ]);

            return redirect()->back()->with('message', 'Option Updated successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    public function destroyQuestionOption($id)
    {
        $decryptedId = decrypt($id);
        $option = SurveyQuestionAnswer::findOrFail($decryptedId);

        if ($option) {
            $option->delete();
            return redirect()->back()->with('message', 'Option deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    public function surveys()
    {
        $teacher_surveys = Survey::where('type', 'teacher')->get();
        $student_surveys = Survey::where('type', 'student')->get();
        return view('admin.survey.survey_lists', compact('teacher_surveys', 'student_surveys'));
    }

    public function respondentClass($id)
    {
        $decryptedId=decrypt($id);
        $surveyClasses = SurveyClass::where('survey_id', $decryptedId)->get();
        $surveyQuestions = SurveyQuestion::where('survey_id', $decryptedId)
            ->whereIn('question_type', ['multiselect', 'radio',])
            ->get();
        $chartsData = [];

        foreach ($surveyQuestions as $surveyQuestion) {
            $labels = [];
            $data = [];
            $questionAnswers = SurveyQuestionAnswer::where('question_id', $surveyQuestion->id)->get();
            foreach ($questionAnswers as $questionAnswer) {
                $labels[] = $questionAnswer->answer_text;
                $data[] = SurveyResponse::where('survey_id', $decryptedId)
                    ->where('question_id', $surveyQuestion->id)
                    ->where('answer', $questionAnswer->answer_text)
                    ->count();
            }
            $chartsData[] = [
                'question_text' => $surveyQuestion->question_text,
                'labels' => $labels,
                'data' => $data,
            ];
        }
        $survey = Survey::find($decryptedId);
        $count=SurveyRespondents::where('survey_id',$survey->id)->count();

        if($count > 0){
            if ($survey->type=='teacher')
            {
                $teachersId = SurveyRespondents::where('survey_id', $survey->id)->pluck('user_id');
                $teachers = User::whereIn('id', $teachersId)->get();
                return view('admin.survey.survey_respondent_class', compact('surveyClasses', 'chartsData', 'survey', 'teachers'));
            }else
            {
                return view('admin.survey.survey_respondent_class', compact('surveyClasses', 'chartsData', 'survey'));
            }
        }
        else
        {
            return redirect()->back()->with('error','Уг судалгааг одоогоор хүн бөглөөгүй байна.');
        }
    }

    public function respondentStudent($class_id,$survey_id)
    {
        $classId = decrypt($class_id);
        $surveyId=decrypt($survey_id);
        $students = User::where('class_id', $classId)->get();
        $respondentStudents = collect();

        foreach ($students as $student) {
            $respondentStudents = $respondentStudents->merge(SurveyRespondents::where('user_id', $student->id)
                ->where('survey_id',$surveyId)
                ->get());
        }

        if ($respondentStudents->isNotEmpty()) {
            return view('admin.survey.survey_respondent_student', compact('respondentStudents'));
        } else {
            return redirect()->back()->with('error', 'Одоогоор судалгаа бөглөөгүй байна');
        }
    }

}
