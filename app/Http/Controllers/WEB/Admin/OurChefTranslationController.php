<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChefTranslation;
use App\Models\OurChef;
use Illuminate\Http\Request;

class OurChefTranslationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function create($language, $id)
    {
        $chef = OurChef::findOrFail($id);

        $chefData = [];
        $chefData['language'] = $language;
        $chefData['our_chef_id'] = $id;

        $data = [];
        $data['chef'] = ChefTranslation::firstOrCreate($chefData);

        if (strtolower($language) === strtolower('en')) {
            $data['chef']->name = $chef->name;
            $data['chef']->designation = $chef->designation;
            $data['chef']->save();

            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];

            return redirect()->route('admin.our-chef.index')->with($notification);
        }

        return view('admin.chef_translation', $data);
    }

    public function update(Request $request, $code, $id)
    {
        if (strtolower($code) === strtolower('en')) {
            return redirect()->route('admin.our-chef.index');
        }

        $rules = [
            'name' => 'required',
            'designation' => 'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'designation.required' => trans('admin_validation.Designation is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $chefTranslation = ChefTranslation::firstOrCreate([
            'language' => $code,
            'our_chef_id' => $id,
        ]);

        $chefTranslation->name = $request->name;
        $chefTranslation->designation = $request->designation;
        $chefTranslation->save();

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('admin.our-chef.index')->with($notification);
    }
}
