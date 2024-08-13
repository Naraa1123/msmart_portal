<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected function authenticated()
    {
        if(Auth::user()->role_as == '1')
        {
            return redirect('admin/dashboard')->with('message','Welcome to Admin dashboard');
        }
        elseif (Auth::user()->role_as == '2')
        {
            return redirect('teacher/dashboard')->with('message','Welcome to Teacher Dashboard');
        }
        elseif (Auth::user()->role_as == '3')
        {
            return redirect('student/dashboard')->with('message','Welcome to Student Dashboard');
        }
        elseif (Auth::user()->role_as == '4')
        {
            return redirect('operator/dashboard')->with('message','Welcome to Operator Dashboard');
        }
        elseif (Auth::user()->role_as == '5')
        {
            return redirect('financier/dashboard')->with('message','Welcome to Financier Dashboard');
        }
        else
        {
            return redirect('/')->with('status','Logged In Successfully');
        }
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'school_id' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            ['school_id' => $request->school_id, 'password' => $request->password],
            $request->filled('remember')
        );
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
