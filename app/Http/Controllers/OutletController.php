<?php

namespace App\Http\Controllers;

use App\Outlet;
use App\Company;
use Illuminate\Http\Request;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['outlets'] = Outlet::orderBy('id', 'desc')->get();
        return view('admin.outlet.outlets_list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['companies'] = Company::select('id', 'name')->where('status', 1)->orderBy('id', 'desc')->get();
        return view('admin.outlet.outlet_form', $data);
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

        $outlet = new Outlet();
        $outlet->name = $request->name;
        $outlet->owner_name = $request->owner_name;
        $outlet->url = $request->url;
        $outlet->email = $request->email;
        $outlet->phone = $request->phone;
        $outlet->address = $request->address;
        $outlet->country = $request->country;
        $outlet->city = $request->city;
        $outlet->lat = $request->lat;
        $outlet->long = $request->long;
        $outlet->company_id = $request->company_id;
        $outlet->minimum_order = $request->minimum_order;

        if(isset($update_id) && !empty($update_id) && $update_id != 0)
        {
            
            $outlet_data = Outlet::where('id', $update_id)->first();
            $outlet_data->update($request->all());
            if ($_FILES['outlet_logo']['size'] > 0) {
            $file = $request->file('outlet_logo');
            if(isset($outlet_data->outlet_logo) && !empty($outlet_data->outlet_logo))
            {
                delete_images_by_name(ORIGNAL_IMAGE_PATH_OUTLET,LARGE_IMAGE_PATH_OUTLET,MEDIUM_IMAGE_PATH_OUTLET,SMALL_IMAGE_PATH_OUTLET,$outlet_data->outlet_logo);
                upload_images(ORIGNAL_IMAGE_PATH_OUTLET,LARGE_IMAGE_PATH_OUTLET,MEDIUM_IMAGE_PATH_OUTLET,SMALL_IMAGE_PATH_OUTLET, $file, $update_id, 'outlet_logo', 'outlets');
            }else{
                upload_images(ORIGNAL_IMAGE_PATH_OUTLET,LARGE_IMAGE_PATH_OUTLET,MEDIUM_IMAGE_PATH_OUTLET,SMALL_IMAGE_PATH_OUTLET, $file, $update_id, 'outlet_logo', 'outlets');
            }
        }
        if ($_FILES['fav_icon']['size'] > 0) {
            $file = $request->file('fav_icon');
            if(isset($outlet_data->fav_icon) && !empty($outlet_data->fav_icon))
            {
                delete_images_by_name(ORIGNAL_IMAGE_PATH_OUTLET,LARGE_IMAGE_PATH_OUTLET,MEDIUM_IMAGE_PATH_OUTLET,SMALL_IMAGE_PATH_OUTLET,$outlet_data->fav_icon);
                upload_images(ORIGNAL_IMAGE_PATH_OUTLET,LARGE_IMAGE_PATH_OUTLET,MEDIUM_IMAGE_PATH_OUTLET,SMALL_IMAGE_PATH_OUTLET, $file, $update_id, 'fav_icon', 'outlets');
            }else{
                upload_images(ORIGNAL_IMAGE_PATH_OUTLET,LARGE_IMAGE_PATH_OUTLET,MEDIUM_IMAGE_PATH_OUTLET,SMALL_IMAGE_PATH_OUTLET, $file, $update_id, 'fav_icon', 'outlets');
            }
        }
        if ($_FILES['admin_logo']['size'] > 0) {
            $file = $request->file('admin_logo');
            if(isset($outlet_data->admin_logo) && !empty($outlet_data->admin_logo))
            {
                delete_images_by_name(ORIGNAL_IMAGE_PATH_OUTLET,LARGE_IMAGE_PATH_OUTLET,MEDIUM_IMAGE_PATH_OUTLET,SMALL_IMAGE_PATH_OUTLET,$outlet_data->admin_logo);
                upload_images(ORIGNAL_IMAGE_PATH_OUTLET,LARGE_IMAGE_PATH_OUTLET,MEDIUM_IMAGE_PATH_OUTLET,SMALL_IMAGE_PATH_OUTLET, $file, $update_id, 'admin_logo', 'outlets');
            }else{
                upload_images(ORIGNAL_IMAGE_PATH_OUTLET,LARGE_IMAGE_PATH_OUTLET,MEDIUM_IMAGE_PATH_OUTLET,SMALL_IMAGE_PATH_OUTLET, $file, $update_id, 'admin_logo', 'outlets');
            }
        }
            return redirect()->route('admin:outlets')->with('success', 'Data Updated successfully!');
        }else
        {
            $outlet->status = 0;
            $outlet->save();
            $last_id = $outlet->id;
            if (isset($last_id) && !empty($last_id)) {
                if (isset($_FILES['outlet_logo']['size'])) {
                    if ($_FILES['outlet_logo']['size'] > 0) {
                        $file = $request->file('outlet_logo');
                        upload_images(ORIGNAL_IMAGE_PATH_OUTLET,LARGE_IMAGE_PATH_OUTLET,MEDIUM_IMAGE_PATH_OUTLET,SMALL_IMAGE_PATH_OUTLET, $file, $last_id, 'outlet_logo', 'outlets');
                    }
                }
                if (isset($_FILES['fav_icon']['size'])) {
                    if ($_FILES['fav_icon']['size'] > 0) {
                        $file = $request->file('fav_icon');
                        upload_images(ORIGNAL_IMAGE_PATH_OUTLET,LARGE_IMAGE_PATH_OUTLET,MEDIUM_IMAGE_PATH_OUTLET,SMALL_IMAGE_PATH_OUTLET, $file, $last_id, 'fav_icon', 'outlets');
                    }
                }
                if (isset($_FILES['admin_logo']['size'])) {
                    if ($_FILES['admin_logo']['size'] > 0) {
                        $file = $request->file('admin_logo');
                        upload_images(ORIGNAL_IMAGE_PATH_OUTLET,LARGE_IMAGE_PATH_OUTLET,MEDIUM_IMAGE_PATH_OUTLET,SMALL_IMAGE_PATH_OUTLET, $file, $last_id, 'admin_logo', 'outlets');
                    }
                }
                $this->generate_outlet_tables($last_id);
                return redirect()->route('admin:outlets')->with('success', 'Outlet registered successfully!');
            } else {
                return back()->with('error', 'Something Went wrong!');
            }
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function show(Outlet $outlet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $outlet_data = Outlet::find($id);
        $companies = Company::select('id', 'name')->where('status', 1)->orderBy('id', 'desc')->get();
        return view('admin.outlet.outlet_form', compact('outlet_data', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Outlet $outlet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Outlet  $outlet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Outlet $outlet)
    {
        //
    }

    public function change_status(Request $request)
    {
        $status = false;
        $message = "Error in Changing Status";
        $outlet_id = $request->outlet_id;
        $outlet_status = $request->status;
        if (isset($outlet_id) && !empty($outlet_id)) {
            if ($outlet_status == 0) {
                $outlet_status = 1;
            } else {
                $outlet_status = 0;
            }

            $outlet = Outlet::find($outlet_id);

            if ($outlet) {
                $outlet->status = $outlet_status;
                $outlet->save();
                $status = true;
                $message = "Status Changed";
                $current_status = $outlet->status;
            }
        }
        return response()->json(['status' => $status, 'message' => $message, 'current_status' => $current_status]);
    }

    function generate_outlet_tables($id)
    {
        //Products table
        Schema::create($id . '_products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->integer('discount');
            $table->string('description');
            $table->boolean('product_available');
            $table->string('outlet_id');
            $table->string('category_id');
            $table->boolean('is_featured');
            $table->boolean('status');
            $table->timestamps();
        });

        //Stock table
        Schema::create($id . '_stock', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->integer('price');
            $table->string('product_id');
            $table->string('outlet_id');
            $table->timestamps();
        });

        //Categories table
        Schema::create($id . '_categories', function (Blueprint $table) {
            $table->id();
            $table->string('cat_name');
            $table->string('cat_desc');
            $table->integer('rank');
            $table->string('image');
            $table->string('icon');
            $table->string('url_slug');
            $table->string('outlet_id');
            $table->timestamps();
        });

        //Orders table
        Schema::create($id . '_orders', function (Blueprint $table) {
            $table->id();
            $table->string('total_items');
            $table->string('transaction_id');
            $table->integer('customer_id');
            $table->string('customer_name');
            $table->string('order_date');
            $table->string('order_type');
            $table->string('payment_method');
            $table->string('payment_status');
            $table->string('delivery_note');
            $table->string('outlet_id');
            $table->string('outlet_name');
            $table->boolean('rejected');
            $table->string('rejected_reason');
            $table->string('rejected_time');
            $table->string('subtotal');
            $table->string('total_price');
            $table->string('order_from');
            $table->string('email');
            $table->string('mobile');
            $table->string('address');
            $table->string('apartment_no');
            $table->string('delivery_address');
            $table->string('city');
            $table->string('country');
            $table->string('delivery_lat');
            $table->string('delivery_long');
            $table->string('delivery_date');
            $table->string('delivery_time');
            $table->timestamps();
        });

        //Orders Detail table
        Schema::create($id . '_orders_detail', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('category_id');
            $table->integer('product_id');
            $table->string('product_name');
            $table->string('product_price');
            $table->string('product_discount');
            $table->string('total_product_price');
            $table->string('stock_id');
            $table->string('specs_label');
            $table->string('quantity');
            $table->timestamps();
        });

        //Order Charges table
        Schema::create($id . '_orders_charges', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('outlet_id');
            $table->integer('charges_name');
            $table->string('charges_type');
            $table->string('charges_amount');
            $table->timestamps();
        });

        //Order Discounts table
        Schema::create($id . '_orders_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('outlet_id');
            $table->integer('discount_name');
            $table->string('discount_type');
            $table->string('discount_amount');
            $table->timestamps();
        });

        //Order Discounts table
        Schema::create($id . '_orders_taxes', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('outlet_id');
            $table->integer('tax_name');
            $table->string('tax_type');
            $table->string('tax_amount');
            $table->timestamps();
        });
    }
}
