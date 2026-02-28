<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\TestimonialTranslation;
use Illuminate\Http\Request;

class TestimonialTranslationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function create($language, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $testimonialData = [];
        $testimonialData['language'] = $language;
        $testimonialData['testimonial_id'] = $id;

        $data = [];
        $data['testimonial'] = TestimonialTranslation::firstOrCreate($testimonialData);

        if (strtolower($language) === strtolower('en')) {
            $data['testimonial']->name = $testimonial->name;
            $data['testimonial']->designation = $testimonial->designation;
            $data['testimonial']->comment = $testimonial->comment;
            $data['testimonial']->save();

            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];

            return redirect()->route('admin.testimonial.index')->with($notification);
        }

        return view('admin.testimonial_translation', $data);
    }

    public function update(Request $request, $code, $id)
    {
        if (strtolower($code) === strtolower('en')) {
            return redirect()->route('admin.testimonial.index');
        }

        $rules = [
            'name' => 'required',
            'designation' => 'required',
            'comment' => 'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'designation.required' => trans('admin_validation.Designation is required'),
            'comment.required' => trans('admin_validation.Comment is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $testimonialTranslation = TestimonialTranslation::firstOrCreate([
            'language' => $code,
            'testimonial_id' => $id,
        ]);

        $testimonialTranslation->name = $request->name;
        $testimonialTranslation->designation = $request->designation;
        $testimonialTranslation->comment = $request->comment;
        $testimonialTranslation->save();

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('admin.testimonial.index')->with($notification);
    }
}
