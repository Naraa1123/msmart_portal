<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Models\Department;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\SchoolClass;
use App\Models\StudentAttendance;
use App\Models\SwitchHistory;
use App\Models\User;
use App\Models\UserContract;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        $departments = Department::all();

        $classes = SchoolClass::get()
            ->sort(function($a, $b) {
                return substr($a->name, 0, 2) <=> substr($b->name, 0, 2);
            });

        return view('admin.user.index', compact('users', 'departments', 'classes'));
    }

    public function graduated()
    {
        $users = User::orderBy('created_at', 'desc')->where('role_as',3)
            ->whereHas('userDetails', function ($query) {
                $query->where('status', 'graduated');
            })
            ->get();

        $departments = Department::all();

        $classes = SchoolClass::get()
            ->sort(function($a, $b) {
                return substr($a->name, 0, 2) <=> substr($b->name, 0, 2);
            });

        return view('admin.user.graduated', compact('users', 'departments', 'classes'));
    }
    public function tookLeave()
    {
        $users = User::orderBy('created_at', 'desc')->where('role_as',3)
            ->whereHas('userDetails', function ($query) {
                $query->where('status', 'took_leave');
            })
            ->get();

        $departments = Department::all();

        $classes = SchoolClass::get()
            ->sort(function($a, $b) {
                return substr($a->name, 0, 2) <=> substr($b->name, 0, 2);
            });

        return view('admin.user.took_leave', compact('users', 'departments', 'classes'));
    }
    public function droppedOut()
    {
        $users = User::orderBy('created_at', 'desc')->where('role_as',3)
            ->whereHas('userDetails', function ($query) {
                $query->where('status', 'dropped_out');
            })
            ->get();

        $departments = Department::all();

        $classes = SchoolClass::get()
            ->sort(function($a, $b) {
                return substr($a->name, 0, 2) <=> substr($b->name, 0, 2);
            });

        return view('admin.user.dropped_out', compact('users', 'departments', 'classes'));
    }

    public function create()
    {
        $classes = SchoolClass::where('status', '0')->get()
            ->sort(function($a, $b) {
                return substr($a->name, 0, 2) <=> substr($b->name, 0, 2);
            });

        return view('admin.user.create', compact('classes'));
    }

    public function store(UserStoreRequest $request)
    {
        $validatedData = $request->validated();

        $authUser = Auth::user();

        if ($authUser->role_as == 1 ) {

            $class = $validatedData['class'];
            $classInstance = SchoolClass::findOrFail($class);
            $class_name = $classInstance->name;

            $role_as = $validatedData['role_as'];

            $school_id = '';
            $user_id = 0;

            if ($role_as == 3) {
                $existingStudentsCount = User::where('class_id', $class)->count();
                $studentNum = $existingStudentsCount + 1;
                $school_id = $class_name . str_pad($studentNum, 2, '0', STR_PAD_LEFT);

                while (User::where('school_id', $school_id)->exists()) {
                    $studentNum++;
                    $school_id = $class_name . str_pad($studentNum, 2, '0', STR_PAD_LEFT);
                }
            } elseif ($role_as == 2 || $role_as == 4 || $role_as == 5) {
                $year = date('y');
                $month = date('m');

                $existingCount = User::where('role_as', $role_as)->count();
                $user_id = $existingCount + 1;

                $prefix = ($role_as == 2 ? 'TE' : ($role_as == 4 ? 'OP' : 'FI'));
                $school_id = $prefix . $year . $month . str_pad($user_id, 2, '0', STR_PAD_LEFT);

                while (User::where('school_id', $school_id)->exists()) {
                    $user_id++;
                    $school_id = $prefix . $year . $month . str_pad($user_id, 2, '0', STR_PAD_LEFT);
                }
            }

            $class_id = $role_as == 3 ? $validatedData['class'] : null;

            $registrationNumberUpper = mb_strtoupper($validatedData['registration_number'], 'UTF-8');

            $user = User::create([
                'class_id' => $class_id,
                'email' => $validatedData['email'],
                'school_id' => $school_id,
                'password' => Hash::make($registrationNumberUpper),
                'role_as' => $role_as,
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $file->move('uploads/user/', $filename);
                $validatedData['image'] = 'uploads/user/' . $filename;
            } else {
                $validatedData['image'] = null;
            }

            $admission_year = $validatedData['admission_year'] ?? $user->created_at;

            UserDetail::create([
                'user_id' => $user->id,
                'firstname' => $validatedData['firstname'],
                'lastname' => $validatedData['lastname'],
                'gender' => $validatedData['gender'],
                'registration_number' => $registrationNumberUpper,
                'phone_number_1' => $validatedData['phone_number_1'],
                'phone_number_2' => $validatedData['phone_number_2'],
                'phone_number_3' => $validatedData['phone_number_3'],
                'date_of_birth' => $validatedData['date_of_birth'],
                'admission_year' => $admission_year,
                'guardian_name' => $validatedData['guardian_name'],
                'guardian_phone_number' => $validatedData['guardian_phone_number'],
                'image' => $validatedData['image'],
                'address' => $validatedData['address'],
                'made_contract' => $validatedData['made_contract'],
            ]);

            if($request->hasFile('contract')){
                $uploadPath = 'uploads/user/contract/';

                $i = 1;
                foreach($request->file('contract') as $file){
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().$i++.'.'.$extension;
                    $file->move($uploadPath,$filename);
                    $finalPathName = $uploadPath.$filename;

                    $user->userContracts()->create([
                        'user_id' => $user->id,
                        'file' => $finalPathName
                    ]);
                }
            }

            if ($user->role_as == 3) {
                $totalAmount = $validatedData['total_amount'];
                $discountPercentage = $validatedData['discount_percentage'];
                $dueAmount = $totalAmount * (1 - $discountPercentage / 100);
                $paidAmount = $validatedData['paid_amount'];
                $paymentMethod = $validatedData['payment_method'];
                $paymentDescription = $validatedData['payment_description'];

                if ($discountPercentage >= 0 || $discountPercentage <= 100) {
                    $payment = Payment::create([
                        'user_id' => $user->id,
                        'total_amount' => $totalAmount,
                        'discount_percentage' => $discountPercentage,
                        'due_amount' => $dueAmount,
                        'status' => ($dueAmount == $paidAmount) ? 'completed' : 'remaining_pays'
                    ]);

                    if ($payment){
                        Fee::create([
                           'payment_id' => $payment->id,
                           'paid_amount' => $paidAmount,
                           'description' => $paymentDescription,
                           'payment_method' => $paymentMethod,
                        ]);
                    }else{
                        return redirect()->back()->with('message', 'Something went wrong');
                    }
                } else {
                    return redirect()->back()->with('message', 'Хямдралын мэдээлэл буруу байна');
                }
            }

        } else {
            return redirect()->back()->with('message', 'Таньд хэрэглэгч нэмэх эрх байхгүй байна');
        }

        return redirect('admin/user')->with('message', 'User created successfully');
    }

    public function edit($id)
    {
        $decryptId = decrypt($id);
        $user = User::findOrFail($decryptId);
        $userDetail = $user->userDetails;
        $classes = SchoolClass::get()
            ->sort(function($a, $b) {
                return substr($a->name, 0, 2) <=> substr($b->name, 0, 2);
            });

        $currentUserClassId = $user->class_id;
        return view('admin.user.edit', compact('user', 'userDetail', 'classes','currentUserClassId'));
    }

    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        $userDetail = $user->userDetails;

        $validatedData = $request->validate([
            'class' =>  'nullable|exists:classes,id',
            'gender' => 'required',
            'reason'=>'nullable',
            'firstname' => 'required|max:200',
            'lastname' => 'required|max:200',
            'status' => 'required',
            'email' => [
                'nullable',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'registration_number' => [
                'required',
                'string',
                'regex:/^[А-ЯҮӨа-яүө]{2}\d{8}$/u',
                Rule::unique('user_details', 'registration_number')->ignore($userDetail->id),
            ],

            'image' => 'nullable|image',
            'phone_number_1' => 'required|integer|digits:8',
            'phone_number_2' => 'nullable|integer|digits:8',
            'phone_number_3' => 'nullable|integer|digits:8',
            'guardian_name' => 'nullable|max:200',
            'guardian_phone_number' => 'nullable|integer|digits:8',
            'date_of_birth' => 'required|date_format:Y-m-d',
            'admission_year' => 'nullable|date_format:Y-m-d',
            'address' => 'nullable',
            'contract' => 'nullable',
            'made_contract'=>'required'
        ]);


        if ($request->hasFile('image')) {

            $destination = $userDetail->image;

            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('uploads/user/', $filename);
            $validatedData['image'] = 'uploads/user/' . $filename;
        }

        if ($user->class_id)
        {
            $classChanged = $user->class_id != $validatedData['class'];
            if ($classChanged) {
                $this->transferUserClassInternal($request, $user, $validatedData['class']);
            }
        }


        if(!empty($validatedData['class']))
        {
            User::where('id', $user->id)->update([
                'class_id' => $validatedData['class'],
                'email' => $validatedData['email'],
            ]);
        }
        else{
            User::where('id', $user->id)->update([
                'email' => $validatedData['email'],
            ]);
        }



        $registrationNumberUpper = strtoupper($validatedData['registration_number']);

        UserDetail::where('id', $userDetail->id)->update([
            'gender' => $validatedData['gender'],
            'reason' => $validatedData['reason'],
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'registration_number' => $registrationNumberUpper,
            'status' => $validatedData['status'],
            'image' => $validatedData['image'] ?? $userDetail->image,
            'phone_number_1' => $validatedData['phone_number_1'],
            'phone_number_2' => $validatedData['phone_number_2'],
            'phone_number_3' => $validatedData['phone_number_3'],
            'guardian_name' => $validatedData['guardian_name'],
            'guardian_phone_number' => $validatedData['guardian_phone_number'],
            'date_of_birth' => $validatedData['date_of_birth'],
            'admission_year' => $validatedData['admission_year'],
            'address' => $validatedData['address'],
            'made_contract' => $validatedData['made_contract'],
        ]);


        return redirect('admin/user')->with('message', 'User updated successfully');
    }

    public function updateDiploma(Request $request ,$id)
    {
        $user=Auth::user();
        if($user->role_as==1)
        {
            $validatedData = $request->validate([
                'has_diploma'=>'required',
                'diploma_name'=>'required',
                'diploma_received_date'=>'required|date'
            ]);

            $dueAmount = Payment::where('user_id', $id)->first('due_amount');
            $dueAmountFloat = $dueAmount->due_amount;
            $payments = Payment::where('user_id', $id)->pluck('paid_amount');
            $totalPaidAmount = $payments->sum();

            if ($dueAmountFloat == $totalPaidAmount) {
                $diplomaUser=UserDetail::where('user_id',$id)->first();
                $diplomaUser->has_diploma=$validatedData['has_diploma'];
                if($validatedData['has_diploma']=='not_received')
                {
                    $diplomaUser->diploma_received_date=null;
                    $diplomaUser->diploma_name=null;
                }
                else
                {
                    if($validatedData['diploma_received_date']>now())
                    {
                        return redirect()->back()->with('error','Диплом олгосон өдөр ирээдүйд байх боломжгүй');
                    }
                    else
                    {
                        $diplomaUser->diploma_received_date=$validatedData['diploma_received_date']; //засвар хийх магадлалтай
                        $diplomaUser->diploma_name=$validatedData['diploma_name'];
                    }
                }
                $diplomaUser->save();
                return redirect()->back()->with('success','Амжилттай шинэчлэгдлээ');
            }
            else
            {
                $leftAmount=$dueAmountFloat-$totalPaidAmount;
                return redirect()->back()->with('error','Уг суралцагч '.$leftAmount.'₮ төгрөгийн төлбөрийн үлдэгдэлтэй байна');
            }
        }
        else
        {
            Auth::logout();
            return redirect()->route('home.page')->with('error', 'Зөвхөн админ уг үйлдлийг хийх боломжтой');
        }
    }

    public function updateCertificate(Request $request ,$id)
    {
        $user=Auth::user();
        if($user->role_as==1)
        {
            $validatedData = $request->validate([
                'has_certificate'=>'required',
                'diploma_received_date'=>'required|date'
            ]);

            $dueAmount = Payment::where('user_id', $id)->first('due_amount');
            $dueAmountFloat = $dueAmount->due_amount;
            $payments = Payment::where('user_id', $id)->pluck('paid_amount');
            $totalPaidAmount = $payments->sum();

            if ($dueAmountFloat == $totalPaidAmount) {
                $diplomaUser=UserDetail::where('user_id',$id)->first();
                $diplomaUser->has_certificate=$validatedData['has_certificate'];
                if($validatedData['has_certificate']=='not_received')
                {
                    $diplomaUser->diploma_received_date=null;
                }
                else
                {
                    if($validatedData['diploma_received_date']>now())
                    {
                        return redirect()->back()->with('error','Сертификат олгосон өдөр ирээдүйд байх боломжгүй');
                    }
                    else {
                        $diplomaUser->diploma_received_date=$validatedData['diploma_received_date']; //засвар хийх магадлалтай
                    }
                }
                $diplomaUser->save();
                return redirect()->back()->with('success','Амжилттай шинэчлэгдлээ');
            }
            else
            {
                $leftAmount=$dueAmountFloat-$totalPaidAmount;
                return redirect()->back()->with('error','Уг суралцагч '.$leftAmount.'₮ төгрөгийн төлбөрийн үлдэгдэлтэй байна');
            }
        }
        else
        {
            Auth::logout();
            return redirect()->route('home.page')->with('error', 'Зөвхөн админ уг үйлдлийг хийх боломжтой');
        }
    }

    protected function transferUserClassInternal(Request $request,User $user, $toClassId)
    {
        $fromClassId = $user->class_id;
        $user->class_id = $toClassId;
        $user->save();

        SwitchHistory::create([
            'user_id' => $user->id,
            'from_class_id' => $fromClassId,
            'to_class_id' => $toClassId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function show($id)
    {
        $decryptId = decrypt($id);
        $user = User::findOrFail($decryptId);
        $userDetail = $user->userDetails;
        $student_attendance =  StudentAttendance::where('user_id', $user->id)->orderBy('attendance_date','DESC')->get();

        return view('admin.user.show',compact('user','userDetail','student_attendance'));
    }

    public function destroy($id)
    {
        $decryptId = decrypt($id);
        $user = User::findOrFail($decryptId);

        if ($user->role_as == 1) {
            return redirect('admin/user')
                ->with('error', 'Admin account ыг устгах боломжгүй');
        }

        $user->userDetails()->delete();
        if($user->userContracts){
            foreach($user->userContracts as $file){
                if(File::exists($file->file)){
                    File::delete($file->file);
                }
            }
        }

        $user->delete();

        return redirect('admin/user')->with('message', 'User deleted successfully');
    }

    public function passwordChange($id)
    {
        $decryptId = decrypt($id);
        $user = User::findOrFail($decryptId);

        return view('admin.user.password_change', compact('user'));
    }

    public function passwordUpdate(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $user = User::findOrFail($id);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('admin/user')->with('message', 'User password change successfully');
    }

    public function showContract($id)
    {
        $decryptId = decrypt($id);
        $user = User::findOrFail($decryptId);

        return view('admin.user.contract', compact('user'));
    }

    public function postContract(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if($request->hasFile('contract')){
            $uploadPath = 'uploads/user/contract/';

            $i = 1;
            foreach($request->file('contract') as $file){
                $extension = $file->getClientOriginalExtension();
                $filename = time().$i++.'.'.$extension;
                $file->move($uploadPath,$filename);
                $finalPathName = $uploadPath.$filename;

                $user->userContracts()->create([
                    'user_id' => $user->id,
                    'file' => $finalPathName
                ]);
            }
        }
        return redirect()->back()->with('message','Data амжилттай хуулагдлаа');
    }

    public function removeContract($id)
    {
        $contract = UserContract::findOrFail($id);

        if(File::exists($contract->file)){
            File::delete($contract->file);
        }
        $contract->delete();
        return redirect()->back()->with('message','Data амжилттай устлаа');

    }
    public function comment(Request $request, $id)
    {
        $item = UserDetail::findOrFail($id);
        $item->update([
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Comment updated successfully!');
    }



}
