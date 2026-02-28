<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomPage;
use App\Models\CustomPageTranslation;
use Illuminate\Http\Request;

class CustomPageTranslationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function create($language, $id)
    {
        $customPage = CustomPage::findOrFail($id);

        $customPageData = [];
        $customPageData['language'] = $language;
        $customPageData['custom_page_id'] = $id;

        $data = [];
        $data['customPage'] = CustomPageTranslation::firstOrCreate($customPageData);

        if (strtolower($language) === strtolower('en')) {
            $data['customPage']->page_name = $customPage->page_name;
            $data['customPage']->description = $customPage->description;
            $data['customPage']->save();

            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];

            return redirect()->route('admin.custom-page.index')->with($notification);
        }

        return view('admin.custom_page_translation', $data);
    }

    public function update(Request $request, $code, $id)
    {
        if (strtolower($code) === strtolower('en')) {
            return redirect()->route('admin.custom-page.index');
        }

        $rules = [
            'page_name' => 'required',
            'description' => 'required',
        ];
        $customMessages = [
            'page_name.required' => trans('admin_validation.Name is required'),
            'description.required' => trans('admin_validation.Description is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $chefTranslation = CustomPageTranslation::firstOrCreate([
            'language' => $code,
            'custom_page_id' => $id,
        ]);

        $chefTranslation->page_name = $request->page_name;
        $chefTranslation->description = $request->description;
        $chefTranslation->save();

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('admin.custom-page.index')->with($notification);
    }
}
