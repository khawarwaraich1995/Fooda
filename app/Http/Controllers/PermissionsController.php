<?php

namespace App\Http\Controllers;

use App\Permissions;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    public function index()
    {
        $data['permissions'] = Permissions::get();
        return view('admin.permissions.permissions_form', $data);
    }

    public function store(Request $request)
    {

       $update_id = $request->id;

        $permissions = new Permissions();
        $permissions->permissions_name = $request->json_permissions;

        if (isset($update_id) && !empty($update_id) && $update_id != 0) {
            $permissions_data = Permissions::where('id', $update_id)->first();
            $permissions_data['permissions_name'] = $request->json_permissions;
            $permissions_data->save();
            return redirect()->route('admin:permissions')->with('success', 'Data Updated successfully!');
        }else{
            $permissions->save();
            $last_id = $permissions->id;

            if (isset($last_id) && !empty($last_id)) {
                return redirect()->route('admin:permissions')->with('success', 'Permissions added successfully!');
            }else
            {
                return back()->with('error', 'Something Went wrong!');
            }
        }
        

    }
}
