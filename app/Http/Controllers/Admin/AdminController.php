<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Utilizator;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function check(Request $request){
         $request->validate([
            'email_utilizator'=>'required|email|exists:utilizatori,email_utilizator|domeniu_restrictionat',
            'password'=>'required|min:6|max:30'
         ],[
             'email_utilizator.exists'=>'Emailul nu exista!',
             'email_utilizator.domeniu_restrictionat' => 'Adresa de email trebuie să se termine cu "@webis.ro", "@utcluj.ro" sau "@staff.utcluj.ro"',

         ]);

         $creds = $request->only('email_utilizator','password');

         if( Auth::guard('utilizator')->attempt($creds) ){
             return redirect()->route('admin.home');
         }else{
             return redirect()->route('admin.login')->with('fail','Datele introduse sunt incorecte!');
         }
    }

    function logout(){
        Auth::guard('utilizator')->logout();
        return redirect('/admin');
    }
}
