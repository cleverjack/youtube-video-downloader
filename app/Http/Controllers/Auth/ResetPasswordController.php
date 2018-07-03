<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\User;
use App\Admin;
use Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        //$this->middleware('guest');
    }
    
    public function showChangeForm(){
        
        
        return view('auth.passwords.reset');
    }
    
    public function changePassword(Request $request){
        
        $user = Admin::all()->first();
        if(Hash::check($request['oldpassword'] , $user->password) && $request['password'] == $request['password_confirmation']){
            
            $user->forceFill([
                'password' => bcrypt($request['password']),
                'remember_token' => Str::random(60),
            ])->save();
    
   
            return redirect('/');
        }
       
        return redirect()->back();
    }
}
