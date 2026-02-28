<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermsAndCondition;
use App\Models\TermsAndConditionTranslation;
use Illuminate\Http\Request;

class TermsAndConditionTranslationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function create($language)
    {
        $data = [];
        $data['language'] = $language;
        $terms = TermsAndCondition::firstOrFail();
        $data['termsAndCondition'] = TermsAndConditionTranslation::firstOrCreate([
            'language' => $language,
            'terms_and_condition_id' => $terms->id,
        ]);

        if (strtolower($language) === strtolower('en')) {
            $data['termsAndCondition']->terms_and_condition = $terms->terms_and_condition;
            $data['termsAndCondition']->save();

            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];
            return redirect()->route('admin.terms-and-condition.index')->with($notification);
        }

        return view('admin.terms_and_condition_translation', $data);
    }

    public function update(Request $request)
    {
        if (strtolower($request->language) === strtolower('en')) {
            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];
            return redirect()->route('admin.terms-and-condition.index')->with($notification);
        }
        $rules = [
            "language" => "required",
            "terms_and_condition_id" => "required",
            'terms_and_condition' => 'required',
        ];

        $customMessages = [
            "language.required" => trans("Language Code is required"),
            "terms_and_condition_id.required" => trans("Terms is required"),
            'terms_and_condition.required' => trans('admin_validation.Terms and condition is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $termsAndCondition = TermsAndConditionTranslation::firstOrCreate([
            'language' => $request->language,
            'terms_and_condition_id' => $request->terms_and_condition_id,
        ]);
        $termsAndCondition->terms_and_condition = $request->terms_and_condition;

        if ($termsAndCondition->save()) {
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
