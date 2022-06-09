<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
     //customer  settings
     public function customerSetting()
     {
         return view('user.setting');
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
                return redirect()->to('/')->with($notification);
            }else{
                $notification=array('message' => 'Your password not matched', 'alert-type'=>'error' );
                return redirect()->back()->with($notification);
            }
     }
}
