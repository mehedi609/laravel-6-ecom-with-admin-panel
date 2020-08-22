<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AdminController extends Controller
{
    private $root_path = "images/admin/admin_photos";

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
                    ->update(['password' => bcrypt($new_password)]);
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

    public function update_admin_details(Request $request)
    {
        $admin_info = Admin::where('email', Auth::guard('admin')->user()->email)->first();

        if ($request->isMethod('post')) {
            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
                'image' => 'required|mimes:jpeg,jpg,png|max:5000'
            ];

            $request->validate($rules);

            $admin_info->name = $request->name;
            $admin_info->mobile = $request->mobile;

            if ($request->hasFile('image')) {
                $img_temp = $request->file('image');
                if ($img_temp->isValid()) {

                    //delete existing old image
                    if (!empty($admin_info->image)) {
                        $old_image_path = "{$this->root_path}/{$admin_info->image}";
                        if (file_exists($old_image_path))
                            unlink($old_image_path);
                    }

                    $unique_img_name = $this->create_unique_image_name($request->name, $img_temp);

                    $img_path_to_save = "{$this->root_path}/{$unique_img_name}";
                    Image::make($img_temp)->resize(300, 400)->save($img_path_to_save);

                    $admin_info->image = $unique_img_name;


                }
            }

            $admin_info->save();

            Toastr::success('Admin details updated Successfully', 'Admin Details Updated!');
            return redirect()->back();
        }

        return view('admin.update_admin_details', compact('admin_info'));
    }

    private function create_unique_image_name($name, $image)
    {
        $slug = Str::slug($name);
        $date_time =  Carbon::now()->toDateString();
        $extension = $image->getClientOriginalExtension();
        $uuid = explode('-', Str::uuid());
        $uuid = array_pop($uuid);
        return "{$slug}-{$date_time}-{$uuid}.{$extension}";
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
