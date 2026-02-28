<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermsAndCondition;
use App\Models\TermsAndConditionTranslation;
use Illuminate\Http\Request;

class PrivacyPolicyTranslationController extends Controller
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
        $data['privacyPolicy'] = TermsAndConditionTranslation::firstOrCreate([
            'language' => $language,
            'terms_and_condition_id' => $terms->id,
        ]);

        if (strtolower($language) === strtolower('en')) {
            $data['privacyPolicy']->privacy_policy = $terms->privacy_policy;
            $data['privacyPolicy']->save();

            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];
            return redirect()->route('admin.privacy-policy.index')->with($notification);
        }

        return view('admin.privacy_policy_translated', $data);
    }

    public function update(Request $request)
    {
        if (strtolower($request->language) === strtolower('en')) {
            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];
            return redirect()->route('admin.privacy-policy.index')->with($notification);
        }

        $rules = [
            "language" => "required",
            "terms_and_condition_id" => "required",
            'privacy_policy' => 'required',
        ];

        $customMessages = [
            "language.required" => trans("Language Code is required"),
            "terms_and_condition_id.required" => trans("Terms is required"),
            'privacy_policy.required' => trans('admin_validation.Privacy policy is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $termsAndCondition = TermsAndConditionTranslation::firstOrCreate([
            'language' => $request->language,
            'terms_and_condition_id' => $request->terms_and_condition_id,
        ]);
        $termsAndCondition->privacy_policy = $request->privacy_policy;

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
