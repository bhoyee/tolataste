<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SettingsTranslation;
use Illuminate\Http\Request;

class SettingsTranslationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function create($code)
    {
        $settings = Setting::firstOrFail();

        $data['language'] = $code;

        $serviceData = [];
        $serviceData['language'] = $code;
        $serviceData['setting_id'] = $settings->id;
        $data['app_section'] = SettingsTranslation::firstOrCreate($serviceData);
        $isDefaule = false;

        if (strtolower($code) === strtolower('en')) {
            $serviceData['app_title'] = $settings->app_title;
            $serviceData['app_description'] = $settings->app_description;
            $data['app_section']->update($serviceData);
            $isDefaule = true;
        }

        if ($isDefaule) {
            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];
            return redirect()->route('admin.app-section')->with($notification);
        }

        return view('admin.app_section_translation', $data);
    }

    public function update(Request $request, $code)
    {
        if (strtolower($code) === strtolower('en')) {
            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];
            return redirect()->route('admin.app-section')->with($notification);
        }

        $settings = Setting::firstOrFail();

        $rules = [
            'app_title' => 'required',
            'app_description' => 'required',
        ];

        $customMessages = [
            'app_title.required' => trans('admin_validation.Title is required'),
            'app_description.required' => trans('admin_validation.description is required'),
        ];

        $validatedData = $this->validate($request, $rules, $customMessages);

        $serviceTranslation = SettingsTranslation::firstOrCreate([
            'language' => $code,
            'setting_id' => $settings->id,
        ]);

        if ($serviceTranslation->update($validatedData)) {
            $notification = trans("admin_validation.Updated Successfully");

            $notification = ["messege" => $notification, "alert-type" => "success"];
        } else {
            $notification = trans("admin_validation.Updating Failed");

            $notification = ["messege" => $notification, "alert-type" => "error"];
        }

        return redirect()
            ->back()
            ->with($notification);
    }
}
