<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerImage;
use App\Models\BannerImageTranslation;
use Illuminate\Http\Request;

class AdvertisementTranslationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function create($code, $id)
    {
        $banner = BannerImage::findOrFail($id);

        $bannerData = [];
        $bannerData['language'] = $code;
        $bannerData['banner_image_id'] = $id;

        $data = [];
        $data['banner'] = BannerImageTranslation::firstOrCreate($bannerData);

        if (strtolower($code) === strtolower('en')) {
            $data['banner']->update([
                'title' => $banner->title,
                'description' => $banner->description,
            ]);

            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];
            return redirect()->route('admin.advertisement')->with($notification);
        }

        return view('admin.advertisement-translation-create', $data);
    }

    public function update(Request $request, $code, $id)
    {
        if (strtolower($code) === strtolower('en')) {
            return redirect()->route('admin.advertisement');
        }

        $rules = [
            'title' => 'required',
            'description' => 'required',
        ];
        $customMessages = [
            'title.required' => trans('admin_validation.Title is required'),
            'description.required' => trans('admin_validation.Description is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        BannerImageTranslation::firstOrCreate([
            'language' => $code,
            'banner_image_id' => $id,
        ])->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('admin.advertisement')->with($notification);
    }
}
