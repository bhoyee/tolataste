<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Homepage;
use App\Models\HomepageTranslation;
use Illuminate\Http\Request;

class HomepageTranslationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function create($code)
    {
        $homepage = Homepage::first();

        $homepageData = [];
        $homepageData['language'] = $code;
        $homepageData['homepage_id'] = $homepage->id;

        $data = [];
        $data['homepage'] = HomepageTranslation::firstOrCreate($homepageData);

        if (strtolower($code) === strtolower('en')) {
            $homepageData['today_special_short_title'] = $homepage->today_special_short_title;
            $homepageData['today_special_long_title'] = $homepage->today_special_long_title;
            $homepageData['today_special_description'] = $homepage->today_special_description;

            $homepageData['menu_short_title'] = $homepage->menu_short_title;
            $homepageData['menu_long_title'] = $homepage->menu_long_title;
            $homepageData['menu_description'] = $homepage->menu_description;

            $homepageData['chef_short_title'] = $homepage->chef_short_title;
            $homepageData['chef_long_title'] = $homepage->chef_long_title;
            $homepageData['chef_description'] = $homepage->chef_description;

            $homepageData['testimonial_short_title'] = $homepage->testimonial_short_title;
            $homepageData['testimonial_long_title'] = $homepage->testimonial_long_title;
            $homepageData['testimonial_description'] = $homepage->testimonial_description;

            $homepageData['blog_short_title'] = $homepage->blog_short_title;
            $homepageData['blog_long_title'] = $homepage->blog_long_title;
            $homepageData['blog_description'] = $homepage->blog_description;

            $data['homepage']->update($homepageData);
            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];
            return redirect()->route('admin.homepage')->with($notification);
        }

        return view('admin.homepage_translate', $data);
    }

    public function update(Request $request, $code)
    {
        if (strtolower($code) === strtolower('en')) {
            return redirect()->route('admin.homepage');
        }

        $rules = [
            'today_special_short_title' => 'required',
        ];

        $customMessages = [
            'today_special_short_title.required' => trans('admin_validation.Title is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $homepage = Homepage::firstOrFail();

        $homepageTranslation = HomepageTranslation::firstOrCreate([
            'language' => $code,
            'homepage_id' => $homepage->id,
        ]);

        $homepageTranslation->fill($request->all());
        $homepageTranslation->save();

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
