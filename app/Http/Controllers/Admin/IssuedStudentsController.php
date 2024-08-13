<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IssuedStudent;
use App\Models\IssuedStudentArchive;
use App\Models\Payment;
use App\Models\User;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;

class IssuedStudentsController extends Controller
{
    public function attendance_issued_students()
    {
        $threeMonthsAgo = now()->subMonths(3);

        $users = User::orderBy('created_at', 'desc')
            ->where('role_as', 3)
            ->whereDoesntHave('issuedStudent', function ($query) {
                $query->where('issue_type', 'attendance');
            })
            ->whereHas('userDetails', function ($query) {
                $query->where('status', 'studying');
            })
            ->withCount(['attendances as attendance_type_1_count' => function ($query) use ($threeMonthsAgo) {
                $query->where('attendance_date', '>=', $threeMonthsAgo)
                    ->where('attendance_type', 1);
            }])
            ->withCount(['attendances as attendance_type_3_count' => function ($query) use ($threeMonthsAgo) {
                $query->where('attendance_date', '>=', $threeMonthsAgo)
                    ->where('attendance_type', 3);
            }])
            ->withCount(['attendances as attendance_type_5_count' => function ($query) use ($threeMonthsAgo) {
                $query->where('attendance_date', '>=', $threeMonthsAgo)
                    ->where('attendance_type', 5);
            }])
            ->whereHas('attendances', function ($query) use ($threeMonthsAgo) {
                $query->where('attendance_date', '>=', $threeMonthsAgo)
                    ->whereIn('attendance_type', [1, 3, 5])
                    ->groupBy('user_id')
                    ->havingRaw('COUNT(*) > 5');
            })
            ->where(function ($query) {
                $query->whereDoesntHave('issuedStudentArchive', function ($query) {
                    $query->where('issue_type', 'attendance');
                })
                    ->orWhereHas('issuedStudentArchive', function ($query) {
                        $query->where('issue_type', 'attendance')
                            ->whereHas('user.attendances', function ($query) {
                                $query->whereIn('attendance_type', [1, 5])
                                    ->whereColumn('attendance_date', '>', 'issued_students_archive.meeting_date')
                                    ->groupBy('user_id')
                                    ->havingRaw('COUNT(*) >= 3');
                            });
                    });
            })
            ->get();
        return view('admin.issued_student.attendance_issued', compact('users'));
    }
    public function payment_issued_students()
    {
        $payments = Payment::with(['fees'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($payment) {
                $totalPaid = $payment->fees->sum('paid_amount');
                $payment->outstanding = $payment->due_amount - $totalPaid;
                return $payment;
            })->filter(function ($payment) {
                return $payment->outstanding > 0;
            });

        return view('admin.issued_student.payment_issued', compact('payments'));
    }
    public function store(Request $request, $id)
    {
        $decryptedId = decrypt($id);
        $user = User::findOrFail($decryptedId);
        $validatedData = $request->validate([
            'note' => 'required|string|max:255',
            'issue_type' => 'required'
        ]);
        $issueStudent = IssuedStudent::where('user_id', $user->id)->get();
        if ($issueStudent->isEmpty())
        {
            IssuedStudent::create([
                'user_id' => $user->id,
                'issue_type' => $validatedData['issue_type'],
                'note' => $validatedData['note'],
            ]);
            return redirect()->back()->with('message', 'Асуудалтай оюутнууд дунд нэмэгдлээ');
        } else {
            return redirect()->back()->with('error', 'Асуудалтай оюутнууд дунд аль хэдийн байна');
        }
    }
    public function issued_students()
    {
        $issued_students = IssuedStudent::orderBy('created_at', 'desc')->get();
        return view('admin.issued_student.issued_student', compact('issued_students'));
    }

    public function destroy($id)
    {
        $decryptedId = decrypt($id);
        $issuedStudent = IssuedStudent::findOrFail($decryptedId);
        $issuedStudent->delete();
        return redirect()->route('admin.issued-students')->with('message', 'Deleted successfully');
    }

    public function archiveDestroy($id)
    {
        $decryptedId = decrypt($id);
        $issuedStudent = IssuedStudentArchive::findOrFail($decryptedId);
        $issuedStudent->delete();
        return redirect()->back()->with('success', 'Deleted successfully');
    }

    public function archive(Request $request)
    {

        $validatedData = $request->validate([
            'user_id' => 'required|string|max:255',
            'issue_type' => 'required',
            'meeting_note' => 'required',
        ]);

        $archiveStudent=IssuedStudentArchive::where('user_id',$validatedData['user_id'])->first();
        if(!empty($archiveStudent)){
            $archiveStudent->update([
                'user_id' => $validatedData['user_id'],
                'issue_type' => $validatedData['issue_type'],
                'meeting_note' => $validatedData['meeting_note'],
                'meeting_date' => now(),
            ]);
        }
        else {
            IssuedStudentArchive::create([
                'user_id' => $validatedData['user_id'],
                'issue_type' => $validatedData['issue_type'],
                'meeting_note' => $validatedData['meeting_note'],
                'meeting_date' => now(),
            ]);
        }
        $issued_student=IssuedStudent::where('user_id', $validatedData['user_id'])->first();
        $issued_student->delete();

        return redirect()->back()->with('success','Амжилттай');
    }
    public function archived_student()
    {
        $archived_students=IssuedStudentArchive::all();
        return view('admin.issued_student.archived_students', compact('archived_students'));
    }

}
