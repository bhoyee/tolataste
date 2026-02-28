<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\AboutUsTranslation;
use Illuminate\Http\Request;

class AboutUsTranslationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function create($language)
    {
        $data = [];
        $data['language'] = $language;
        $aboutUs = AboutUs::firstOrFail();
        $aboutUsTranslation = AboutUsTranslation::firstOrCreate([
            'language' => $language,
            'about_us_id' => $aboutUs->id,
        ]);

        if (strtolower($language) === strtolower('en')) {

            $aboutUsTranslation->about_us_short_title = $aboutUs->about_us_short_title;
            $aboutUsTranslation->about_us_long_title = $aboutUs->about_us_long_title;
            $aboutUsTranslation->about_us = $aboutUs->about_us;
            $aboutUsTranslation->why_choose_us_short_title = $aboutUs->why_choose_us_short_title;
            $aboutUsTranslation->why_choose_us_long_title = $aboutUs->why_choose_us_long_title;
            $aboutUsTranslation->why_choose_us_description = $aboutUs->why_choose_us_description;
            $aboutUsTranslation->title_one = $aboutUs->title_one;
            $aboutUsTranslation->title_two = $aboutUs->title_two;
            $aboutUsTranslation->title_three = $aboutUs->title_three;
            $aboutUsTranslation->title_four = $aboutUs->title_four;
            $aboutUsTranslation->video_title = $aboutUs->video_title;
            $aboutUsTranslation->save();

            $notification = trans("admin_validation.Updated Successfully");

            $notification = ["messege" => $notification, "alert-type" => "success"];

            return redirect()->route('admin.about-us.index')->with($notification);
        }
        $data['about_us'] = $aboutUsTranslation;
        return view('admin.about-us-translation', $data);
    }

    public function update(Request $request)
    {
        if (strtolower($request->language) === strtolower('en')) {
            return redirect()->route('admin.about-us.index');
        }

        $rules = [
            "language" => "required",
            "about_us_id" => "required",
        ];

        $customMessages = [
            "language.required" => trans("Language Code is required"),
            "about_us_id.required" => trans("About us is required"),
        ];

        $this->validate($request, $rules, $customMessages);

        $aboutUsTranslation = AboutUsTranslation::firstOrCreate([
            'language' => $request->language,
            'about_us_id' => $request->about_us_id
        ]);

        if ($request->update_type) {
            $rules = [
                "about_us_short_title" => "required_if:update_type,aboutUs|string|max:255",
                "about_us_long_title" => "required_if:update_type,aboutUs|string|max:255",
                "about_us" => "required_if:update_type,aboutUs",
                "why_choose_us_short_title" => "required_if:update_type,whyChooseUs|string|max:255",
                "why_choose_us_long_title" => "required_if:update_type,whyChooseUs|string|max:255",
                "why_choose_us_description" => "required_if:update_type,whyChooseUs",
                "title_one" => "nullable|string|max:255",
                "title_two" => "nullable|string|max:255",
                "title_three" => "nullable|string|max:255",
                "title_four" => "nullable|string|max:255",
                "video_title" => "required_if:update_type,video|string|max:255",
            ];

            $customMessages = [
                "about_short_title.required_if" => trans("Short title is required"),
                "about_long_title.required_if" => trans("Long title is required"),
                "about_us.required_if" => trans("About us is required"),
                "why_choose_us_short_title.required_if" => trans("Short title is required"),
                "why_choose_us_long_title.required_if" => trans("Long title is required"),
                "why_choose_us_description.required_if" => trans("Description is required"),
                "video_title.required_if" => trans("Video title is required"),
            ];
        }

        $validated = $this->validate($request, $rules, $customMessages);

        $aboutUsTranslation->fill($validated);

        if ($aboutUsTranslation->save()) {
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
