<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AttendanceRequestController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::user()->id);
        $student_attendance_requests =  AttendanceRequest::where('user_id', Auth::user()->id)->orderBy('created_at','desc')->get();
        return view('student.attendance_request.index', compact('user','student_attendance_requests'));
    }

    public function create()
    {
        return view('student.attendance_request.create');
    }



    public function store(Request $request)
    {
        function unicode_word_count($string) {
            $words = preg_split('/[^\p{L}\p{N}]+/u', $string, -1, PREG_SPLIT_NO_EMPTY);
            return count($words);
        }


        Validator::extend('word_count_min', function ($attribute, $value, $parameters, $validator) {
            return unicode_word_count($value) >= $parameters[0];
        });

        Validator::extend('word_count_max', function ($attribute, $value, $parameters, $validator) {
            return unicode_word_count($value) <= $parameters[0];
        });

        $validatedData = $request->validate([
            'request_type' => 'required',
            'request_start_date' => 'required|date_format:Y-m-d',
            'request_end_date' => 'required|date_format:Y-m-d',
            'description' => 'required|string|word_count_min:10|word_count_max:400',
            'attachment' => 'nullable',
        ], [
            'request_start_date.required' => 'Чөлөө эхлэх өдрийг сонгоно уу',
            'request_end_date.required' => 'Чөлөө дуусах өдрийг сонгоно уу',
            'description.required' => 'Тайлбарын хэсгийг заавал бичнэ үү',
            'description.string' => 'Тайлбар string утга байх ёстой',
            'description.word_count_min' => 'Тайлбар нь 10 аас дээш үгнээс бүрдсэн байх ёстой',
            'description.word_count_max' => 'Тайлбар нь 400 аас дээш үгнээс бүрдсэн байх боломжгүй',
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/attendance_request/', $filename);
            $validatedData['attachment'] = 'uploads/attendance_request/' . $filename;
        } else {
            $validatedData['attachment'] = null;
        }

        AttendanceRequest::create([
            'user_id' => Auth::user()->id,
            'request_type' => $validatedData['request_type'],
            'request_start_date' => $validatedData['request_start_date'],
            'request_end_date' => $validatedData['request_end_date'],
            'description' => $validatedData['description'],
            'attachment' => $validatedData['attachment'],
        ]);

        return redirect('student/attendance-request')->with('message', 'Чөлөөний хүсэлт амжилттай үүслээ');

    }

    public function destroy($id)
    {
        $attendance_request = AttendanceRequest::findOrFail($id);
        $attendance_request->delete();
        return redirect('student/attendance-request')->with('message', 'Чөлөөний хүсэлт устгагдлаа');
    }
}
