<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }


    public function login(Request $request)
    {
        if ($request->isMethod('POST')) {

            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6|max:150'
            ]);

            $login_credentials = [
                'email' => $request->email,
                'password' => $request->password
            ];

            if (Auth::guard('admin')->attempt($login_credentials)) {
                Toastr::success('Thank you for login', 'Welcome Back!!');
                return redirect(route('admin.dashboard'));
            } else {
                Toastr::warning('Invalid Credentials.', 'Access Denied');
                return redirect(route('admin.login'));
            }
        }
        return view('admin.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        Toastr::info('Thank you for staying with us', 'Logged Out!!');
        return redirect(route('admin.login'));
    }

    public function settings(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|min:4|max:50',
                'current_password' => 'required|min:6',
                'new_password' => 'required|confirmed|min:6',
            ]);

            $current_password = Auth::guard('admin')->user()->password;
            $new_password = $request->new_password;

            if (!Hash::check($request->current_password, $current_password)) {
                Session::flash('error_msg', 'Your current password is not current');
            } elseif (Hash::check($new_password, $current_password)) {
                Session::flash('error_msg', 'Your entered an old password');
            } else {
                Admin::where('id', Auth::guard('admin')->user()->id)
                    ->update(['password' => bcrypt($new_password), 'name' => $request->name]);
                Toastr::success('Password Updated Successfully', 'Password Updated');
            }

            return redirect()->back();
        }

        $admin_info = Admin::where('email', Auth::guard('admin')->user()->email)->first();

        return view('admin.settings', compact('admin_info'));
    }

    public function check_current_password(Request $request)
    {
        $current_password = $request->current_password;

        if (Hash::check($current_password, Auth::guard('admin')->user()->password)) {
            return json_encode(true);
        } else {
            return json_encode(false);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
