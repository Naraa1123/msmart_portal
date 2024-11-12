<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $usersPerMonth = User::select(
            DB::raw("COUNT(*) as count"),
            DB::raw("YEAR(created_at) year, MONTH(created_at) month")
        )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $labels = [];
        $data = [];

        foreach ($usersPerMonth as $row) {
            $monthName = date("F", mktime(0, 0, 0, $row->month, 10));
            $labels[] = $monthName . ' ' . $row->year;
            $data[] = $row->count;
        }

        //        Эр эмийн pie

        $femaleusers = UserDetail::where('gender', 'female')
            ->whereHas('user', function ($query) {
                $query->where('role_as', '3');
            })
            ->count();
        $maleusers = UserDetail::where('gender', 'male')
            ->whereHas('user', function ($query) {
                $query->where('role_as', '3');
            })
            ->count();
        $otherusers= UserDetail::where('gender', 'male')
            ->whereHas('user', function ($query) {
                $query->where('role_as', '1,2,4');
            })
            ->count();
        $seconddata = [ 'labels' => ['Эм', 'Эр','Бусад'],
            'seconddata' => [$femaleusers, $maleusers,$otherusers],
        ];

        // Төгссөн болон төгсөөгүйн pie
        $graduatedusers = UserDetail::where('status', 'graduated')
            ->whereHas('user', function ($query) {
                $query->where('role_as', '3');
            })
            ->count();
        $studying = UserDetail::where('status', 'studying')
            ->whereHas('user', function ($query) {
                $query->where('role_as', '3');
            })
            ->count();
        $took_leave = UserDetail::where('status', 'took_leave')
            ->whereHas('user', function ($query) {
                $query->where('role_as', '3');
            })
            ->count();
        $dropped_out = UserDetail::where('status', 'dropped_out')
            ->whereHas('user', function ($query) {
                $query->where('role_as', '3');
            })
            ->count();

        $thirddata = [ 'labels' => ['Төгссөн', 'Суралцаж байгаа','Чөлөө авсан','Гарсан'],
            'thirddata' => [$graduatedusers, $studying,$took_leave,$dropped_out],
        ];


        //  13/16 17/20 21/25 26/30 31/35 35+ насны харьцаатай
        $thirteenYearsAgo = Carbon::now()->subYears(13)->format('Y-m-d');
        $sixteenYearsAgo = Carbon::now()->subYears(16)->format('Y-m-d');

        $seventeenYearsAgo = Carbon::now()->subYears(17)->format('Y-m-d');
        $twentyYearsAgo = Carbon::now()->subYears(20)->format('Y-m-d');

        $twentyOneYearsAgo = Carbon::now()->subYears(21)->format('Y-m-d');
        $twentyFiveYearsAgo = Carbon::now()->subYears(25)->format('Y-m-d');

        $twentySixYearsAgo = Carbon::now()->subYears(26)->format('Y-m-d');
        $thirtyYearsAgo = Carbon::now()->subYears(30)->format('Y-m-d');

        $thirtyOneYearsAgo = Carbon::now()->subYears(31)->format('Y-m-d');
        $thirtyFiveYearsAgo = Carbon::now()->subYears(35)->format('Y-m-d');

        $thirtySixYearsAgo = Carbon::now()->subYears(35)->format('Y-m-d');

        $thirteenToSixteen = UserDetail::whereBetween('date_of_birth', [$sixteenYearsAgo, $thirteenYearsAgo])->whereHas('user', function ($query) {
            $query->where('role_as', '3');
        })->count();
        $seventeenToTwenty = UserDetail::whereBetween('date_of_birth', [$twentyYearsAgo, $seventeenYearsAgo])->whereHas('user', function ($query) {
            $query->where('role_as', '3');
        })->count();
        $twentyOneToTwentyFive = UserDetail::whereBetween('date_of_birth', [$twentyFiveYearsAgo, $twentyOneYearsAgo])->whereHas('user', function ($query) {
            $query->where('role_as', '3');
        })->count();
        $twentySixToThirty = UserDetail::whereBetween('date_of_birth', [$thirtyYearsAgo, $twentySixYearsAgo])->whereHas('user', function ($query) {
            $query->where('role_as', '3');
        })->count();
        $thirtyOneToThirtyFive = UserDetail::whereBetween('date_of_birth', [$thirtyFiveYearsAgo, $thirtyOneYearsAgo])->whereHas('user', function ($query) {
            $query->where('role_as', '3');
        })->count();
        $thirtySixAbove = UserDetail::where('date_of_birth', '<=', $thirtySixYearsAgo)->whereHas('user', function ($query) {
            $query->where('role_as', '3');
        })->count();


        $fourthdata = [ 'labels' => ['13-16', '17-20','21-25','26-30','31-35','36+'],
            'fourthdata' => [$thirteenToSixteen, $seventeenToTwenty,$twentyOneToTwentyFive,$twentySixToThirty,$thirtyOneToThirtyFive,$thirtySixAbove],
        ];

        //Аль тэнхимд хэдэн оюутан байгааг харуулах график

        $commonConditions = function ($query) {
            $query->where('role_as', '3');
        };

        $ProgrammerOneYear = UserDetail::where('status', 'studying')
            ->whereHas('user', function ($query) {
                $query->where('school_id', 'LIKE', 'SO%');
            })
            ->whereHas('user', $commonConditions)
            ->count();

        $ProgrammerSixMonth = UserDetail::where('status', 'studying')
            ->whereHas('user', function ($query) {
                $query->where('school_id', 'LIKE', 'SS%');
            })
            ->whereHas('user', $commonConditions)
            ->count();

        $GraphicDesignOneYear = UserDetail::where('status', 'studying')
            ->whereHas('user', function ($query) {
                $query->where('school_id', 'LIKE', 'GO%');
            })
            ->whereHas('user', $commonConditions)
            ->count();

        $GraphicDesignSixMonth = UserDetail::where('status', 'studying')
            ->whereHas('user', function ($query) {
                $query->where('school_id', 'LIKE', 'GF%');
            })
            ->whereHas('user', $commonConditions)
            ->count();

        $InterierOneYear = UserDetail::where('status', 'studying')
            ->whereHas('user', function ($query) {
                $query->where('school_id', 'LIKE', 'IO%');
            })
            ->whereHas('user', $commonConditions)
            ->count();

        $InterierFiveMonth = UserDetail::where('status', 'studying')
            ->whereHas('user', function ($query) {
                $query->where('school_id', 'LIKE', 'IF%');
            })
            ->whereHas('user', $commonConditions)
            ->count();

        $KidFirstStage = UserDetail::where('status', 'studying')
            ->whereHas('user', function ($query) {
                $query->where('school_id', 'LIKE', 'KT%');
            })
            ->whereHas('user', $commonConditions)
            ->count();

        $KidSecondStage = UserDetail::where('status', 'studying')
            ->whereHas('user', function ($query) {
                $query->where('school_id', 'LIKE', 'KS%');
            })
            ->whereHas('user', $commonConditions)
            ->count();


        $TribleWork = UserDetail::where('status', 'studying')
            ->whereHas('user', function ($query) {
                $query->where('school_id', 'LIKE', 'TO%');
            })
            ->whereHas('user', $commonConditions)
            ->count();


        $fifthdata = [ 'labels' => ['Програм хангамж 1 жил', 'Програм хангамж 5 сар','График Дизайн 1 жил','График Дизайн 5 сар',
            'Интерьер Дизайн 1 жил','Интерьер Дизайн 5 сар','Хүүхдийн Анги 1 шат','Хүүхдийн Анги 2 шат','Гурвалсан 1 жил'],
            'fifthdata' => [$ProgrammerOneYear, $ProgrammerSixMonth,$GraphicDesignOneYear,$GraphicDesignSixMonth,
                $InterierOneYear,$InterierFiveMonth,$KidFirstStage,$KidSecondStage,$TribleWork],
        ];


        // 9 сарын аниудын анги дүүргэлтийн график

        $currentMonth = date('y') . date('m');

        $programmerClasses = SchoolClass::where('name', 'LIKE', "%{$currentMonth}%")
            ->select('name')
            ->withCount('users')
            ->get();

        $ProgramLabels = [];
        $ProgramData = [];

        foreach ($programmerClasses as $class) {
            $ProgramLabels[] = $class->name;
            $ProgramData[] = $class->users_count;
        }

        $sixthdata = [
            'labels' => $ProgramLabels,
            'sixthdata' => $ProgramData,
        ];

        return view('admin.dashboard', compact('labels', 'data','seconddata','thirddata','fourthdata','fifthdata','sixthdata'));
    }

    public function getClassData(Request $request)
    {
        $selectedMonth = $request->query('month', date('Y-m'));

        list($year, $month) = explode('-', $selectedMonth);

        $formattedMonth = substr($year, 2, 2) . $month;

        $programmerClasses = SchoolClass::where('name', 'LIKE', "%{$formattedMonth}%")
            ->select('name')
            ->withCount('users')
            ->get();


        $ProgramLabels = [];
        $ProgramData = [];

        foreach ($programmerClasses as $class) {
            $ProgramLabels[] = $class->name;
            $ProgramData[] = $class->users_count;
        }

        return response()->json([
            'labels' => $ProgramLabels,
            'sixthdata' => $ProgramData,
        ]);
    }

    public function income()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $feesPerDay = DB::table('fees')
            ->select(DB::raw('DATE(paid_date) as date'), DB::raw('SUM(paid_amount) as total'))
            ->whereMonth('paid_date', $currentMonth)
            ->whereYear('paid_date', $currentYear)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $labels = [];
        $data = [];

        foreach ($feesPerDay as $fee) {
            $labels[] = $fee->date;
            $data[] = $fee->total;
        }

        return view('admin.income', compact('labels', 'data'));
    }
}
