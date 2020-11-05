<?php

namespace App\Http\Controllers;

use App\Roles;
use App\Permissions;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['roles'] = Roles::all();
        return view('admin.roles.roles_list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.role_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $update_id = $request->id;

        $roles = new Roles();
        $roles->title = $request->title;

        if (isset($update_id) && !empty($update_id) && $update_id != 0) {
            $roles_data = Roles::where('id', $update_id)->first();
            $roles_data->update($request->all());
            return redirect()->route('admin:roles')->with('success', 'Data Updated successfully!');
        }else{
            $roles->status = 1;
            $roles->save();
            $last_id = $roles->id;
            if (isset($last_id) && !empty($last_id)) {
                return redirect()->route('admin:roles')->with('success', 'Role added successfully!');
            }else
            {
                return back()->with('error', 'Something Went wrong!');
            }
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function permission_modules(Request $request)
    {
        $role_id = $request->id;

        $permissions = Permissions::get();
        $data['permissions_list'] = json_decode($permissions[0]['permissions_name']);

        $roles = Roles::where('id', $role_id)->first();
        $data['permissions'] = json_decode($roles->permissions);
        $data['role_id'] = $role_id;
        return view('admin.roles.permission_modules', $data);
    }

    public function permission_modules_update(Request $request)
    {
        $modules = json_encode($request->modules);
        $role_id = $request->id;
        
        $roles = Roles::where('id', $role_id)->first();
        if(isset($roles) && !empty($roles))
        {
            $roles->permissions = $modules;
            $roles->save();
    
            return redirect()->route('admin:roles')->with('success', 'Permissions Updated for '.$roles->title.'!');
        }else{
            return back()->with('error', 'Something Went wrong!');
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function edit(Roles $roles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Roles $roles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Roles $roles)
    {
        //
    }
}
