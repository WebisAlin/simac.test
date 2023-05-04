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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Guard to be used for authentication.
     *
     * @var string
     */
    protected $guard = 'didactic'; // Add this line

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override the default login function for custom authentication.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'email_cd' => [
                'required',
                'email',
                'exists:cadre_didactice,email_cd',
                'domeniu_restrictionat'
            ],
            'password' => 'required|min:5|max:30'
        ], [
            'email_cd.exists' => 'Emailul nu exista!',
            'email_cd.domeniu_restrictionat' => 'Adresa de email trebuie să se termine cu "@webis.ro", "@utcluj.ro" sau "@staff.utcluj.ro"',
        ]);

             
        $creds = $request->only('email_cd', 'password');

        if(Auth::guard('didactic')->attempt($creds)){
            return redirect()->route('home');
        } else {
            return redirect()->route('login')->with('fail', 'Datele introduse sunt incorecte!');
        }
        
    }
}
