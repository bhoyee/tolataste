<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\Setting;
use File;

class PartnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
        $partners = Partner::all();
        $setting = Setting::first();
        return view('admin.partner', compact('partners','setting'));
    }

    public function create(){
        return view('admin.create_partner');
    }

    public function store(Request $request){
        $rules = [
            'image' => 'required',
        ];
        $customMessages = [
            'image.required' => trans('admin_validation.Image is required'),
        ];
        $this->validate($request, $rules,$customMessages);


        $partner = new Partner();
        if($request->image){
            $extention = $request->image->getClientOriginalExtension();
            $bg_image = 'partner'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $bg_image = 'uploads/custom-images/'.$bg_image;
            $request->image->move(public_path('uploads/custom-images/'),$bg_image);
            $partner->image = $bg_image;
        }

        $partner->status = $request->status;
        $partner->link = $request->link;
        $partner->save();

        $notification= trans('admin_validation.Created Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.partner.index')->with($notification);
    }

    public function edit($id){
        $partner = Partner::find($id);

        return view('admin.edit_partner', compact('partner'));
    }

    public function update(Request $request, $id){
        $partner = Partner::find($id);
        if($request->image){
            $existing_bg = $partner->image;
            $extention = $request->image->getClientOriginalExtension();
            $bg_image = 'partner'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $bg_image = 'uploads/custom-images/'.$bg_image;
            $request->image->move(public_path('uploads/custom-images/'),$bg_image);
            $partner->image = $bg_image;
            $partner->save();
            if($existing_bg){
                if(File::exists(public_path().'/'.$existing_bg))unlink(public_path().'/'.$existing_bg);
            }
        }

        $partner->status = $request->status;
        $partner->link = $request->link;
        $partner->save();

        $notification= trans('admin_validation.Updated Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->route('admin.partner.index')->with($notification);
    }

    public function destroy($id){
        $partner = Partner::find($id);
        $existing_bg = $partner->image;
        if($existing_bg){
            if(File::exists(public_path().'/'.$existing_bg))unlink(public_path().'/'.$existing_bg);
        }
        $partner->delete();

        $notification= trans('admin_validation.Delete Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);
    }

    public function update_partner_image(Request $request){

        $setting = Setting::first();
        if($request->background_image){
            $existing_bg = $setting->partner_background;
            $extention = $request->background_image->getClientOriginalExtension();
            $bg_image = 'counter-bg'.date('-Y-m-d-h-i-s-').rand(999,9999).'.'.$extention;
            $bg_image = 'uploads/website-images/'.$bg_image;
            $request->background_image->move(public_path('uploads/website-images/'),$bg_image);
            $setting->partner_background = $bg_image;
            $setting->save();
            if($existing_bg){
                if(File::exists(public_path().'/'.$existing_bg))unlink(public_path().'/'.$existing_bg);
            }
        }

        $notification= trans('admin_validation.Updated Successfully');
        $notification=array('messege'=>$notification,'alert-type'=>'success');
        return redirect()->back()->with($notification);

    }
}
