<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\CounterTranslation;
use App\Models\Footer;
use App\Models\FooterTranslation;
use Illuminate\Http\Request;

class FooterTranslationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function create($language, $id)
    {
        $footer = Footer::firstOrFail();

        $footerData = [];
        $footerData['language'] = $language;
        $footerData['footer_id'] = $footer->id;

        $data = [];
        $data['footerTranslated'] = FooterTranslation::firstOrCreate($footerData);
        if (strtolower($language) === strtolower('en')) {
            $data['footerTranslated']->about_us = $footer->about_us;
            $data['footerTranslated']->address = $footer->address;
            $data['footerTranslated']->copyright = $footer->copyright;
            $data['footerTranslated']->save();
            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];

            return redirect()->route('admin.footer.index')->with($notification);
        }

        return view('admin.website_footer_translation', $data);
    }

    public function update(Request $request, $code, $id)
    {
        if (strtolower($code) === strtolower('en')) {
            return redirect()->route('admin.footer.index');
        }

        $rules = [
            'address' => 'required',
            'copyright' => 'required',
            'about_us' => 'required',
        ];
        $customMessages = [
            'address.required' => trans('admin_validation.Address is required'),
            'copyright.required' => trans('admin_validation.Copyright is required'),
            'about_us.required' => trans('admin_validation.About us is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $footerTranslation = FooterTranslation::firstOrCreate([
            'language' => $code,
            'footer_id' => $id,
        ]);

        $footerTranslation->about_us = $request->about_us;
        $footerTranslation->address = $request->address;
        $footerTranslation->copyright = $request->copyright;
        $footerTranslation->save();

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('admin.footer.index')->with($notification);
    }
}
