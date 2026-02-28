<?php

namespace App\Http\Controllers\WEB\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;


class AdminLoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::ADMIN;

    public function __construct()
    {
        $this->middleware('guest:admin')->except('adminLogout');
    }

    public function adminLoginPage(){
        $setting = Setting::first();
        return view('admin.auth.login',compact('setting'));
    }


  public function storeLogin(Request $request)
{
    Log::info('🔐 Login attempt started', ['email' => $request->email]);

    $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    $customMessages = [
        'email.required' => trans('admin_validation.Email is required'),
        'password.required' => trans('admin_validation.Password is required'),
    ];
    $this->validate($request, $rules, $customMessages);

    $credential = [
        'email' => $request->email,
        'password' => $request->password
    ];

    $isAdmin = Admin::where('email', $request->email)->first();
    if ($isAdmin) {
        Log::info('✅ Admin record found', ['admin_id' => $isAdmin->id, 'status' => $isAdmin->status]);

        if ($isAdmin->status == 1) {
            if (Hash::check($request->password, $isAdmin->password)) {
                Log::info('✅ Password check passed');

                if (Auth::guard('admin')->attempt($credential, $request->remember)) {
                    Log::info('✅ Auth guard login success', [
                        'guard' => 'admin',
                        'admin_id' => auth('admin')->id()
                    ]);

                    return redirect()->route('admin.dashboard')
                        ->with(['messege' => trans('admin_validation.Login Successfully'), 'alert-type' => 'success']);
                } else {
                    Log::warning('❌ Auth guard login failed');
                }
            } else {
                Log::warning('❌ Password mismatch');
            }
        } else {
            Log::warning('❌ Admin account inactive', ['admin_id' => $isAdmin->id]);
        }
    } else {
        Log::warning('❌ Admin email not found');
    }

    return redirect()->route('admin.login')
        ->with(['messege' => trans('admin_validation.Invalid login'), 'alert-type' => 'error']);
}

    public function adminLogout(){
        Auth::guard('admin')->logout();
        $notification= trans('admin_validation.Logout Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.login')->with($notification);
    }
}
