<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqTranslation;
use Illuminate\Http\Request;

class FaqTranslationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function create($language, $id)
    {
        $faq = Faq::findOrFail($id);

        $faqData = [];
        $faqData['language'] = $language;
        $faqData['faq_id'] = $id;

        $data = [];
        $data['faq'] = FaqTranslation::firstOrCreate($faqData);

        if (strtolower($language) === strtolower('en')) {
            $data['faq']->question = $faq->question;
            $data['faq']->answer = $faq->answer;
            $data['faq']->save();

            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];

            return redirect()->route('admin.faq.index')->with($notification);
        }

        return view('admin.faq_translation', $data);
    }

    public function update(Request $request, $code, $id)
    {
        if (strtolower($code) === strtolower('en')) {
            return redirect()->route('admin.faq.index');
        }

        $rules = [
            'question' => 'required',
            'answer' => 'required',
        ];
        $customMessages = [
            'question.required' => trans('admin_validation.Question is required'),
            'answer.required' => trans('admin_validation.Answer is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $faqTranslation = FaqTranslation::firstOrCreate([
            'language' => $code,
            'faq_id' => $id,
        ]);

        $faqTranslation->question = $request->question;
        $faqTranslation->answer = $request->answer;
        $faqTranslation->save();

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('admin.faq.index')->with($notification);
    }
}
