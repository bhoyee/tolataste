<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Language;
use Illuminate\Http\Request;
use Image;
use File;

class AboutUsController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function index()
    {
        $about_us = AboutUs::with('translation')->first();
        $languages = Language::all();

        return view("admin.about-us", compact("about_us", "languages"));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            "about_short_title" => "required",
            "about_long_title" => "required",
            "about_us" => "required",
        ];

        $customMessages = [
            "about_short_title.required" => trans("Short title is required"),
            "about_long_title.required" => trans("Long title is required"),
            "about_us.required" => trans("About us is required"),
        ];

        $this->validate($request, $rules, $customMessages);

        $aboutUs = AboutUs::find($id);

        if ($request->about_us_image) {
            $exist_banner = $aboutUs->about_us_image;
            $extention = $request->about_us_image->getClientOriginalExtension();
            $banner_name = "about-us" . date("-Y-m-d-h-i-s-") . rand(999, 9999) . "." . $extention;
            $banner_name = "uploads/website-images/" . $banner_name;
            Image::make($request->about_us_image)->save(public_path() . "/" . $banner_name);
            $aboutUs->about_us_image = $banner_name;
            $aboutUs->save();

            if ($exist_banner) {
                if (File::exists(public_path() . "/" . $exist_banner)) {
                    unlink(public_path() . "/" . $exist_banner);
                }
            }
        }

        $aboutUs->about_us = $request->about_us;
        $aboutUs->about_us_short_title = $request->about_short_title;
        $aboutUs->about_us_long_title = $request->about_long_title;
        $aboutUs->save();

        $notification = trans("admin_validation.Updated Successfully");

        $notification = ["messege" => $notification, "alert-type" => "success"];

        return redirect()
            ->back()
            ->with($notification);
    }

    public function why_choose_us(Request $request, $id)
    {
        $rules = [
            "why_choose_us_short_title" => "required",
            "why_choose_us_long_title" => "required",
            "why_choose_us_description" => "required",
        ];

        $customMessages = [
            "why_choose_us_short_title.required" => trans("Short title is required"),
            "why_choose_us_long_title.required" => trans("Long title is required"),
            "why_choose_us_description.required" => trans("Description is required"),
        ];

        $this->validate($request, $rules, $customMessages);

        $aboutUs = AboutUs::find($id);

        if ($request->why_choose_us_background) {
            $exist_banner = $aboutUs->why_choose_us_background;
            $extention = $request->why_choose_us_background->getClientOriginalExtension();
            $banner_name = "why_choose_us_background" . date("-Y-m-d-h-i-s-") . rand(999, 9999) . "." . $extention;
            $banner_name = "uploads/website-images/" . $banner_name;
            Image::make($request->why_choose_us_background)->save(public_path() . "/" . $banner_name);
            $aboutUs->why_choose_us_background = $banner_name;
            $aboutUs->save();

            if ($exist_banner) {
                if (File::exists(public_path() . "/" . $exist_banner)) {
                    unlink(public_path() . "/" . $exist_banner);
                }
            }
        }

        if ($request->why_choose_us_foreground_one) {
            $exist_banner = $aboutUs->why_choose_us_foreground_one;
            $extention = $request->why_choose_us_foreground_one->getClientOriginalExtension();
            $banner_name = "why_choose_us_foreground_one" . date("-Y-m-d-h-i-s-") . rand(999, 9999) . "." . $extention;
            $banner_name = "uploads/website-images/" . $banner_name;
            Image::make($request->why_choose_us_foreground_one)->save(public_path() . "/" . $banner_name);
            $aboutUs->why_choose_us_foreground_one = $banner_name;
            $aboutUs->save();

            if ($exist_banner) {
                if (File::exists(public_path() . "/" . $exist_banner)) {
                    unlink(public_path() . "/" . $exist_banner);
                }
            }
        }

        if ($request->why_choose_us_foreground_two) {
            $exist_banner = $aboutUs->why_choose_us_foreground_two;
            $extention = $request->why_choose_us_foreground_two->getClientOriginalExtension();
            $banner_name = "why_choose_us_foreground_two" . date("-Y-m-d-h-i-s-") . rand(999, 9999) . "." . $extention;
            $banner_name = "uploads/website-images/" . $banner_name;
            Image::make($request->why_choose_us_foreground_two)
                ->save(public_path() . "/" . $banner_name);
            $aboutUs->why_choose_us_foreground_two = $banner_name;
            $aboutUs->save();

            if ($exist_banner) {
                if (File::exists(public_path() . "/" . $exist_banner)) {
                    unlink(public_path() . "/" . $exist_banner);
                }
            }
        }

        $aboutUs->why_choose_us_short_title = $request->why_choose_us_short_title;
        $aboutUs->why_choose_us_long_title = $request->why_choose_us_long_title;
        $aboutUs->why_choose_us_description = $request->why_choose_us_description;
        $aboutUs->title_one = $request->title_one;
        $aboutUs->title_two = $request->title_two;
        $aboutUs->title_three = $request->title_three;
        $aboutUs->title_four = $request->title_four;
        $aboutUs->icon_one = $request->icon_one;
        $aboutUs->icon_two = $request->icon_two;
        $aboutUs->icon_three = $request->icon_three;
        $aboutUs->icon_four = $request->icon_four;
        $aboutUs->save();

        $notification = trans("admin_validation.Updated Successfully");
        $notification = ["messege" => $notification, "alert-type" => "success"];
        return redirect()->back()->with($notification);
    }

    public function video_update(Request $request, $id)
    {
        $rules = [
            "video_title" => "required",
            "video_id" => "required",
        ];

        $customMessages = [
            "video_title.required" => trans("Video title is required"),
            "video_id.required" => trans("Video id is required"),
        ];

        $this->validate($request, $rules, $customMessages);

        $aboutUs = AboutUs::find($id);

        if ($request->video_background) {
            $exist_banner = $aboutUs->video_background;
            $extention = $request->video_background->getClientOriginalExtension();
            $banner_name = "video_background" . date("-Y-m-d-h-i-s-") . rand(999, 9999) . "." . $extention;
            $banner_name = "uploads/website-images/" . $banner_name;
            Image::make($request->video_background)->save(public_path() . "/" . $banner_name);
            $aboutUs->video_background = $banner_name;
            $aboutUs->save();

            if ($exist_banner) {
                if (File::exists(public_path() . "/" . $exist_banner)) {
                    unlink(public_path() . "/" . $exist_banner);
                }
            }
        }

        $aboutUs->video_title = $request->video_title;
        $aboutUs->video_id = $request->video_id;
        $aboutUs->save();

        $notification = trans("admin_validation.Updated Successfully");
        $notification = ["messege" => $notification, "alert-type" => "success"];
        return redirect()->back()->with($notification);
    }
}
