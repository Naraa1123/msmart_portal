<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});


Auth::routes();

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role_as == 1) {
            return redirect('admin/dashboard');
        } elseif (Auth::user()->role_as == 2) {
            return redirect('teacher/dashboard');
        } elseif (Auth::user()->role_as == 3) {
            return redirect('student/dashboard');
        } elseif (Auth::user()->role_as == 4) {
            return redirect('operator/dashboard');
        } elseif (Auth::user()->role_as == 5) {
            return redirect('financier/dashboard');
        } else {
            return redirect('/');
        }
    }
    return view('auth.login');
});

Route::middleware('checkIP')->get('get-data', function () {
//    return view('admin.test');
    return 'Амжилттай аашлаа';
});


//ADMIN SECTION API
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('income', [\App\Http\Controllers\Admin\DashboardController::class, 'income'])->name('admin.monthly-income');
    Route::get('get-class-data', [\App\Http\Controllers\Admin\DashboardController::class, 'getClassData']);


    Route::controller(\App\Http\Controllers\Admin\DepartmentController::class)->group(function () {
        Route::get('department', 'index')->name('admin.department-all');
        Route::get('department/create', 'create')->name('admin.department-create');
        Route::post('department', 'store')->name('admin.department-insert');
        Route::get('department/edit/{id}', 'edit')->name('admin.department-edit');
        Route::put('department/{id}', 'update')->name('admin.department-update');
        Route::get('department/delete/{id}', 'destroy')->name('admin.department-destroy');
    });

    Route::controller(\App\Http\Controllers\Admin\EntrantController::class)->group(function () {
        Route::get('entrant', 'index')->name('admin.entrant-all');
        Route::get('entrant/create', 'create')->name('admin.entrant-create');
        Route::post('entrant', 'store')->name('admin.entrant-insert');
        Route::get('entrant/edit/{id}', 'edit')->name('admin.entrant-edit');
        Route::put('entrant/{id}', 'update')->name('admin.entrant-update');
        Route::get('entrant/delete/{id}', 'destroy')->name('admin.entrant-destroy');
        Route::get('entrant/change-status/{id}/{status}', 'changeStatus');

    });

    Route::controller(\App\Http\Controllers\Admin\ClassController::class)->group(function () {
        Route::get('class', 'index')->name('admin.class-all');
        Route::get('class/create', 'create')->name('admin.class-create');
        Route::get('class/students/{id}', 'students')->name('admin.class-students');
        Route::post('class', 'store');
        Route::get('class/edit/{id}', 'edit');
        Route::put('class/{id}', 'update');
        Route::get('class/delete/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\Admin\ClassPlanController::class)->group(function () {
        Route::get('class_plan', 'index')->name('admin.class-plan-all');
        Route::get('plan/check/{id}/{class_name}', 'check')->name('admin.check-class-plan');
    });

    Route::controller(\App\Http\Controllers\Admin\SubjectController::class)->group(function () {
        Route::get('subject', 'index')->name('admin.subject-all');
        Route::get('subject/create', 'create')->name('admin.subject-create');
        Route::post('subject', 'store');
        Route::get('subject/edit/{id}', 'edit');
        Route::put('subject/{id}', 'update');
        Route::get('subject/delete/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\Admin\GradingTopicController::class)->group(function () {
        Route::get('grading-topic', 'index')->name('admin.grading-topic');
        Route::get('/get-grading-topics', 'getGradingTopics');
        Route::get('grading-topic/create', 'create')->name('admin.grading-topic.create');
        Route::get('grading-topic/edit/{id}', 'edit')->name('admin.grading-topic.edit');
        Route::put('grading-topic/update/{id}', 'update')->name('admin.grading-topic.update');
        Route::get('grading-topic/delete/{id}', 'destroy')->name('admin.grading-topic.delete');
        Route::post('grading-topic/store', 'store')->name('admin.grading-topic.store');

    });

    Route::controller(\App\Http\Controllers\Admin\ClassSubjectController::class)->group(function () {
        Route::get('class-subjects', 'index')->name('admin.class_subject-all');
        Route::get('class-subjects/create', 'create')->name('admin.class_subject-create');
        Route::post('class-subjects', 'store');
        Route::get('class-subjects/edit/{id}', 'edit')->name('admin.class-subject.edit');
        Route::put('class-subjects/{id}', 'update');
        Route::get('class-subjects/delete/{id}', 'destroy');

        Route::get('class-subject/add/{classId}/{subjectId}', 'addAction')->name('admin.class-subjects.add');
        Route::get('class-subject/remove/{classId}/{subjectId}', 'removeAction')->name('admin.class-subjects.remove');
        Route::get('class-subjects/toggle-status/{classId}/{subjectId}', 'toggleStatus')->name('admin.class-subjects.toggle-status');

    });


    //Payment
    Route::controller(\App\Http\Controllers\Admin\PaymentController::class)->group(function () {
        Route::get('payment', 'index')->name('admin.payment-all');
        Route::get('outstanding-payment', 'outstanding')->name('admin.payment-outstanding');
        Route::post('payment/{id}/mpay', 'mpay')->name('admin.payment.pay');
    });

    // USER

    Route::controller(\App\Http\Controllers\Admin\UserController::class)->group(function () {
        Route::get('user', 'index')->name('admin.user-all');
        Route::get('user/graduated', 'graduated')->name('admin.user-graduated');
        Route::get('user/took_leave', 'tookLeave')->name('admin.user-took-leave');
        Route::get('user/dropped_out', 'droppedOut')->name('admin.user-dropped-out');
        Route::get('user/create', 'create')->name('admin.user-create');
        Route::post('user', 'store');
        Route::get('user/edit/{id}', 'edit');
        Route::put('user/{id}', 'update');
        Route::put('user/update-diploma/{id}', 'updateDiploma')->name('admin.update-diploma');
        Route::put('user/update-certificate/{id}', 'updateCertificate')->name('admin.update-certificate');

        Route::get('user/delete/{id}', 'destroy');

        Route::get('user/show/{id}', 'show');

        Route::get('user/password/{id}', 'passwordChange');
        Route::post('user/password_update/{id}', 'passwordUpdate');

        Route::get('user/contract/{id}', 'showContract');
        Route::post('user/contract/{id}', 'postContract');
        Route::get('user/contract/delete/{id}', 'removeContract');

    });

    Route::controller(\App\Http\Controllers\Admin\SwitchHistoryController::class)->group(function () {
        Route::get('user-class-switch-history', 'index')->name('admin.switch.index');
        Route::get('user-class-attendance-history/{id}', 'attendance')->name('admin.student-attendance');
    });

    Route::controller(\App\Http\Controllers\Admin\TeacherClassController::class)->group(function () {
        Route::get('teacher-classes', 'index')->name('admin.teacher_classes-all');
        Route::get('teacher-classes/create', 'create')->name('admin.teacher_classes-create');
        Route::post('teacher-classes', 'store');

        Route::get('teacher-classes/edit/{id}', 'edit')->name('admin.teacher_classes.edit');
        Route::put('teacher-classes/{id}', 'update')->name('admin.teacher-classes.update');
        Route::get('teacher-classes/delete/{id}', 'destroy');

        Route::get('teacher-classes/remove/{teacherId}/{classId}', 'removeClass')
            ->name('admin.teacher-classes.remove');

        Route::get('teacher-classes/add/{teacherId}/{classId}', 'addClass')
            ->name('admin.teacher-classes.add');
    });

    Route::controller(\App\Http\Controllers\Admin\ClassTimetableController::class)->group(function () {
        Route::get('timetable', 'index')->name('admin.timetable-all');
        Route::get('timetable/{classId}', 'getTimeData');
        Route::post('timetable', 'store')->name('admin.timetable.store');
        Route::get('timetable/{class_id}/{week_id}', 'destroy')->name('admin.timetable.destroy');
    });

    Route::controller(\App\Http\Controllers\Admin\StudentAttendanceController::class)->group(function () {
        Route::get('attendance/student', 'index')->name('admin.attendance-all');
        Route::get('attendance/student/fetch', 'fetch')->name('fetch.student.attendance');
        Route::post('attendance/student', 'comment')->name('admin.attendance-comment-add');
        Route::post('attendance/student/save', 'store');
        Route::get('/attendance-report', 'showAttendanceReport')->name('attendance.search');
    });

    Route::controller(\App\Http\Controllers\Admin\AttendanceRequestController::class)->group(function () {
        Route::get('attendance-request', 'index')->name('admin.attendance-requests');
        Route::get('attendance-request/change-decision/{id}/{decision}', 'changeDecision');
        Route::get('attendance-request/delete/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\Admin\SubjectGradeController::class)->group(function () {
        Route::get('subject-grade', 'class_choose')->name('admin.subject-class');
        Route::get('subject-grade/show/{id}', 'get_student');
        Route::get('subject-grade/grade/{id}', 'view_grades');
        Route::post('subject-grade/grade/update-or-create', 'updateOrCreate')->name('admin.subject-grade.updateOrCreate');
    });

    Route::controller(\App\Http\Controllers\Admin\TeacherNewsController::class)->group(function () {
        Route::get('teacher/news', 'index')->name('admin.teacher.news');
        Route::get('teacher/news/create', 'create')->name('admin.teacher.news-create');
        Route::post('teacher/news', 'addNews')->name('admin.teacher.news-store');
        Route::get('teacher/news/edit/{id}', 'editNews');
        Route::put('teacher/news/{id}', 'updateNews');
        Route::get('teacher/news/delete/{id}', 'deleteNews');
        Route::post('ckeditor-upload-image', 'uploadImage')->name('ckeditor.upload');
    });

    Route::controller(\App\Http\Controllers\Admin\StudentNewsController::class)->group(function () {
        Route::get('student/news', 'index')->name('admin.student.news');
        Route::get('student/news/create', 'create')->name('admin.student.news-create');
        Route::post('student/news', 'addNews')->name('admin.student.news-store');
        Route::get('student/news/edit/{id}', 'editNews');
        Route::put('student/news/{id}', 'updateNews');
        Route::get('student/news/delete/{id}', 'deleteNews');
    });

    Route::controller(\App\Http\Controllers\Admin\SpecialNewsController::class)->group(function () {
        Route::get('special/news', 'index')->name('admin.special.news');
        Route::get('special/news/create', 'create')->name('admin.special.news-create');
        Route::post('special/news', 'addNews')->name('admin.special.news-store');
        Route::get('special/news/edit/{id}', 'editNews');
        Route::put('special/news/{id}', 'updateNews');
        Route::get('special/news/delete/{id}', 'deleteNews');
        Route::delete('admin/special/news/image/{id}', 'deleteImage')->name('admin.special.news.deleteImage');
    });


    Route::controller(\App\Http\Controllers\Admin\SurveyController::class)->group(function () {
        Route::get('survey', 'index')->name('admin.survey.list');
        Route::post('survey', 'store')->name('admin.survey.store');
        Route::put('survey/{id}', 'update')->name('admin.survey.update');
        Route::get('survey/delete/{id}', 'destroy')->name('admin.survey.delete');

        Route::get('survey/question/{id}', 'surveyQuestion')->name('admin.survey.questions');
        Route::post('survey/question/{id}', 'surveyQuestionStore')->name('admin.survey.question.store');
        Route::put('survey/question/{id}', 'surveyQuestionUpdate')->name('admin.survey.question.update');
        Route::get('survey/question/delete/{id}', 'surveyQuestionDestroy')->name('admin.survey.question.delete');

        Route::get('survey/question/option/{id}', 'showQuestionOption')->name('admin.survey.question.option');
        Route::post('survey/question/option/{id}', 'storeQuestionOption')->name('admin.survey.question.option.store');
        Route::put('survey/question/option/{id}', 'updateQuestionOption')->name('admin.survey.question.option.update');
        Route::get('survey/question/option/delete/{id}', 'destroyQuestionOption')->name('admin.survey.question.option.delete');

        Route::get('survey/survey_lists', 'surveys')->name('admin.list-of-surveys');
        Route::get('survey/survey_respondent_class/{id}', 'respondentClass')->name('admin.survey_respondent_class');
        Route::get('survey/survey_respondent_student/{class_id}/{survey_id}', 'respondentStudent')->name('admin.survey-respondent-student');
    });

    Route::controller(\App\Http\Controllers\Admin\SurveyClassController::class)->group(function () {
        Route::get('survey-class', 'index')->name('admin.survey-class.index');
        Route::post('survey-class', 'store')->name('admin.survey-class.store');
        Route::get('survey-class/delete/{id}', 'destroy')->name('admin.survey-class.delete');
    });

    Route::controller(\App\Http\Controllers\Admin\ReportController::class)->group(function () {
        Route::get('report', 'index')->name('admin.reported-students');
        Route::get('report/contacted', 'contact')->name('admin.report-contacted-students');
        Route::put('report/update/{id}', 'update')->name('admin.reported-student-update');

    });

    Route::controller(\App\Http\Controllers\TestController::class)->group(function () {
        Route::get('give-survey', 'index');

    });

    Route::controller(\App\Http\Controllers\Admin\IssuedStudentsController::class)->group(function () {
        Route::get('issued-students', 'issued_students')->name('admin.issued-students');
        Route::get('archived-students', 'archived_student')->name('admin.archived-students');
        Route::get('payment-issued-students', 'payment_issued_students')->name('admin.payment-issued-students');
        Route::get('attendance-issued-students', 'attendance_issued_students')->name('admin.attendance-issued-students');
        Route::post('issue-store/{id}', 'store')->name('admin.issue-store');
        Route::get('issue-delete/{id}', 'destroy')->name('admin.issue-delete');
        Route::get('issue-delete/archive/{id}', 'archiveDestroy')->name('admin.issue-archive-delete');
        Route::post('issued-student/archive', 'archive')->name('admin.issued.student.archive');
    });
});
//TEACHER SECTION API
Route::prefix('teacher')->middleware(['auth', 'isTeacher'])->group(function () {

    Route::controller(\App\Http\Controllers\Teacher\DashboardController::class)->group(function () {
        Route::get('dashboard', 'index')->name('teacher.dashboard');
        Route::get('багшийн-гүйцэтгэл-үнэлэх-журам', 'juram1')->name('teacher.juram1');
        Route::get('багшийн-ёс-зүй', 'juram2')->name('teacher.juram2');
        Route::get('дадлага', 'juram3')->name('teacher.juram3');
        Route::get('хүүхэд-хамгааллын-бодлого', 'juram4')->name('teacher.juram4');
        Route::get('сурагчдын-тэтгэлэгт-хамрагдах-тухай', 'juram5')->name('teacher.juram5');
        Route::get('survey', 'survey')->name('teacher.survey');
        Route::get('survey', 'getClassData')->name('teacher.survey');

    });

    Route::controller(\App\Http\Controllers\Student\SurveyResponseController::class)->group(function () {
        Route::post('submit/{id}', 'submit')->name('teacher.submit-survey');
        Route::post('report/{id}', 'report')->name('teacher.student-report-store');
        Route::get('report/student', 'students')->name('teacher.reported-students');
    });


    Route::controller(\App\Http\Controllers\Teacher\ProfileController::class)->group(function () {
        Route::get('profile', 'edit')->name('teacher.profile');
        Route::post('profile/password-update/{id}', 'updatePassword')->name('teacher.password');
    });

    Route::controller(\App\Http\Controllers\Teacher\ClassUserController::class)->group(function () {
        Route::get('classes', 'index')->name('teacher.classes');
        Route::get('grade-classes', 'grade')->name('teacher.classes-grade');
        Route::get('class/students/{id}', 'viewStudents');
        Route::post('class/subject/change-status/{id}', 'changeStatus');

        Route::get('class/student/grades/{id}', 'viewGrades')->name('teacher.view-grade');
//        Route::get('class/student/grade/{id}', 'viewGrades')->name('teacher.view-grade');
        Route::post('class/student/grade/update-or-create', 'updateOrCreate')->name('teacher.subject-grade.updateOrCreate');
    });

    Route::controller(\App\Http\Controllers\Teacher\StudentAttendanceController::class)->group(function () {
        Route::post('attendance/student', 'index')->name('teacher.attendance-all');
        Route::get('attendance/student', 'index')->name('teacher.attendance-plans');
        Route::post('attendance/student/save', 'store');
        Route::get('/attendance-report', 'showAttendanceReport')->name('teacher.attendance.search');
    });

    Route::controller(\App\Http\Controllers\Teacher\TopicGradeController::class)->group(function () {
        Route::get('/teacher/class/student/topic-grade/{id}', 'index')->name('teacher.topic-grade');
        Route::post('/teacher/class/student/topic-grade/store', 'updateOrCreate')->name('teacher.topic-grade.updateOrCreate');

    });

    Route::controller(\App\Http\Controllers\Teacher\TimetableController::class)->group(function () {
        Route::get('timetable', 'index')->name('teacher.timetable');
        Route::get('attendance-request', 'attendanceRequests')->name('teacher.attendance_request');
        Route::get('attendance-request/change-decision/{id}/{decision}', 'changeDecision');
    });

    Route::controller(\App\Http\Controllers\Teacher\ClassSubjectTopicController::class)->group(function () {
        Route::get('plan/see', 'see')->name('teacher.see-plans');
        Route::get('plan/all/{id}/{class_name}', 'all')->name('teacher.all-class-plan');
        Route::post('plan', 'store')->name('teacher.subject-topic-store');
        Route::put('plan', 'update')->name('teacher.subject-topic-update');
        Route::get('plan/delete/{id}', 'destroy')->name('teacher.subject-topic-delete');
    });

});

//STUDENT SECTION API
Route::prefix('student')->middleware(['auth', 'isStudent'])->group(function () {

    Route::controller(\App\Http\Controllers\Student\DashboardController::class)->group(function () {
        Route::get('dashboard', 'index')->name('student.dashboard');
        Route::get('durem', 'durem')->name('student.durem');
        Route::get('payment', 'tulbur')->name('student.tulbur');
        Route::get('survey', 'survey')->name('student.survey');
        Route::get('grade', 'grade')->name('student.grade');
        Route::get('news', 'news')->name('student.news');
        Route::get('special_news', 'special')->name('student.special-news');
    });

    Route::controller(\App\Http\Controllers\Student\SurveyResponseController::class)->group(function () {
        Route::post('submit/{id}', 'submit')->name('student.submit-survey');
    });


    Route::controller(\App\Http\Controllers\Student\ProfileController::class)->group(function () {
        Route::get('profile', 'edit')->name('student.profile');
        Route::post('profile/password-update/{id}', 'updatePassword')->name('student.password');
        Route::put('profile/info/{id}', 'updateProfile')->name('student.update-profile');
    });

    Route::get('timetable', [\App\Http\Controllers\Student\TimetableController::class, 'index'])->name('student.timetable');

    Route::controller(\App\Http\Controllers\Student\AttendanceRequestController::class)->group(function () {
        Route::get('attendance-request', 'index')->name('student.attendance-requests');
        Route::get('attendance-request/create', 'create')->name('student.attendance-request-create');
        Route::post('attendance-request', 'store');
        Route::get('attendance-request/delete/{id}', 'destroy');
    });

    Route::controller(\App\Http\Controllers\Student\PlanController::class)->group(function () {
        Route::get('plan', 'index')->name('student.plan');
    });

    Route::get('my-attendance', [\App\Http\Controllers\Student\AttendanceController::class, 'index'])->name('student.attendance');
});

//Operator SECTION API
Route::prefix('operator')->middleware(['auth', 'isOperator'])->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\Operator\DashboardController::class, 'index'])->name('operator.dashboard');
});

//Financier SECTION API
Route::prefix('financier')->middleware(['auth', 'isFinancier'])->group(function () {
    Route::get('dashboard', [\App\Http\Controllers\Financier\DashboardController::class, 'index'])->name('financier.dashboard');
});



