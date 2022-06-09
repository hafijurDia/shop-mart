<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Image;
use File;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //seo page show method
    public function seo()
    {
    	$data = DB::table('seos')->first();
    	return view('admin.setting.seo',compact('data'));
    }

    //update function
    public function seoUpdate(Request $request,$id)
    {
    	$data=array();
    	$data['meta_title'] = $request->meta_title;
    	$data['meta_author'] = $request->meta_author;
    	$data['meta_tag'] = $request->meta_tag;
    	$data['meta_description'] = $request->meta_description;
    	$data['meta_keyword'] = $request->meta_keyword;
    	$data['google_verifaction'] = $request->google_verifaction;
    	$data['google_analytics'] = $request->google_analytics;
    	$data['alexa_verification'] = $request->alexa_verification;
    	$data['google_adsense'] = $request->google_adsense;
    	
    	DB::table('seos')->where('id',$id)->update($data);
    	$notification=array('message' => 'SEO Setting Successfully Updated', 'alert-type'=>'success' );
        return redirect()->back()->with($notification);
    }

    //smtp page show method
    public function smtp()
    {
    	$data = DB::table('smtp')->first();
    	return view('admin.setting.smtp',compact('data'));
    }

    //smtp update method()
    public function smtpUpdate(Request $request,$id)
    {
        
		$data=array();
		$data['mailer'] = $request->mailer;
		$data['host'] = $request->host;
		$data['port'] = $request->port;
		$data['username'] = $request->username;
		$data['password'] = $request->password;

		DB::table('smtp')->where('id',$id)->update($data);
		$notification=array('message' => 'SMTP Setting Successfully Updated', 'alert-type'=>'success' );
    	return redirect()->back()->with($notification);

    }

	//website setting read method
	public function website()
	{
		$data = DB::table('settings')->first();
		return view('admin.setting.website_setting',compact('data'));
	}

	//sebsite settings update
	public function webUpdate(Request $request)
	{
		$data = array();
    	$data['currency'] = $request->currency;
    	$data['phone_one'] = $request->phone_one;
    	$data['phone_two'] = $request->phone_two;
    	$data['main_email'] = $request->main_email;
    	$data['support_email'] = $request->support_email;
    	$data['address'] = $request->address;
    	$data['facebook'] = $request->facebook;
    	$data['twitter'] = $request->twitter;
    	$data['instagram'] = $request->instagram;
    	$data['linkedin'] = $request->linkedin;
    	$data['youtube'] = $request->youtube;

		if ($request->logo) { //if new logo add
			$logo = $request->logo;
			$logoname = uniqid().'.'.$logo->getClientOriginalExtension();
			Image::make($logo)->resize(340,120)->save('public/files/setting/'.$logoname); //image with intervention
			$data['logo'] = 'public/files/setting/'.$logoname;
		}else{ //if new logo not add
			$data['logo'] = $request->old_logo;
		}

		if ($request->favicon) { //if new logo add
			$favlogo = $request->favicon;
			$favname = uniqid().'.'.$favlogo->getClientOriginalExtension();
			Image::make($favlogo)->resize(32,32)->save('public/files/setting/'.$favname); //image with intervention
			$data['favicon'] = 'public/files/setting/'.$favname;
		}else{ //if new logo not add
			$data['favicon'] = $request->old_favicon;
		}
		DB::table('settings')->where('id',$request->id)->update($data);
		$notification=array('message' => 'Wbsite settings Updated', 'alert-type'=>'success' );
    	return redirect()->back()->with($notification);
	}

}

	
