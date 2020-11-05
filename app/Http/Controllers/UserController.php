<?php

namespace App\Http\Controllers;

use App\User;
use App\Roles;
use App\Outlet;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        $data['users'] = User::all();
        return view('admin.users.users_list', $data);
    }

    public function create(){

        $data['roles'] = Roles::all();
        $data['outlets'] = Outlet::all();
        return view('admin.users.user_form', $data);
    }

    public function edit($id){
        $user_data = User::find($id);
        $roles = Roles::all();
        $outlets = Outlet::all();
        return view('admin.users.user_form', compact('user_data','roles','outlets'));

    }

    public function store(Request $request)
    {
        $update_id = $request->id;
        $outlets = json_encode($request->outlets);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->gender = $request->gender;
        $user->role_id = 2;
        $user->outlets = $outlets;
        $user->country = $request->country;
        $user->city = $request->city;

        if (isset($update_id) && !empty($update_id) && $update_id != 0) {
            $user_data = User::where('id', $update_id)->first();
            $user_data->update($request->all());

            if ($_FILES['profile_image']['size'] > 0) {
                if(isset($user_data->profile_image) && !empty($user_data->profile_image))
                {
                    $file = $request->file('profile_image');
                    delete_images_by_name(ORIGNAL_IMAGE_PATH_USERS,LARGE_IMAGE_PATH_USERS,MEDIUM_IMAGE_PATH_USERS,SMALL_IMAGE_PATH_USERS,$user_data->profile_image);
                    upload_images(ORIGNAL_IMAGE_PATH_USERS,LARGE_IMAGE_PATH_USERS,MEDIUM_IMAGE_PATH_USERS,SMALL_IMAGE_PATH_USERS, $file, $update_id, 'profile_image', 'users');
                }
            }
            return redirect()->route('admin:users')->with('success', 'Data Updated successfully!');
        }else{
            $user->status = 1;
            $user->save();
            $last_id = $user->id;
            if (isset($last_id) && !empty($last_id)) {
                if (isset($_FILES['profile_image']['size'])) {
                    if ($_FILES['profile_image']['size'] > 0) {
                        $file = $request->file('profile_image');
                        upload_images(ORIGNAL_IMAGE_PATH_USERS,LARGE_IMAGE_PATH_USERS,MEDIUM_IMAGE_PATH_USERS,SMALL_IMAGE_PATH_USERS, $file, $last_id, 'profile_image', 'users');
                    }
                }
                return redirect()->route('admin:users')->with('success', 'User registered successfully!');
            } else {
                return back()->with('error', 'Something Went wrong!');
            }

        }
    }
}
