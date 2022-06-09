<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

     //admin after logging
    public function admin(){
        return view('admin.home');
    }

    //admin custom logout
    public function logout(){
        Auth::logout();

        $notification=array('message' => 'Your are logged out!', 'alert-type'=>'success' );
        return redirect()->route('admin.login')->with($notification);
    }

    //password change
    public function passwordChange()
    {
        return view('admin.profile.password_change');
    }

    //password update
    public function passwordUpdate(Request $request)
    {
        $validated = $request->validate([
        'old_password' => 'required',
        'password' => 'required|min:6|confirmed',
        
        ]);

        $current_pass = Auth::user()->password;
        $oldpass = $request->old_password;
        $newpass = $request->password;
        if (Hash::check($oldpass,$current_pass)) {
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();
            $notification=array('message' => 'Your password changed!', 'alert-type'=>'success' );
            return redirect()->route('admin.login')->with($notification);
        }else{
            $notification=array('message' => 'Your password not matched', 'alert-type'=>'success' );
            return redirect()->back()->with($notification);
        }
    }
        
}
