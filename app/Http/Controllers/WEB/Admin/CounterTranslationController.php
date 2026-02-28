<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use App\Models\CounterTranslation;
use Illuminate\Http\Request;

class CounterTranslationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function create($language, $id)
    {
        $counter = Counter::findOrFail($id);

        $counterData = [];
        $counterData['language'] = $language;
        $counterData['counter_id'] = $id;

        $data = [];
        $data['counter'] = CounterTranslation::firstOrCreate($counterData);

        if (strtolower($language) === strtolower('en')) {
            $data['counter']->title = $counter->title;
            $data['counter']->save();
            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];

            return redirect()->route('admin.counter.index')->with($notification);
        }

        return view('admin.counter_translation', $data);
    }

    public function update(Request $request, $code, $id)
    {
        if (strtolower($code) === strtolower('en')) {
            return redirect()->route('admin.counter.index');
        }

        $rules = [
            'title' => 'required',
        ];
        $customMessages = [
            'title.required' => trans('admin_validation.Title is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $counterTranslation = CounterTranslation::firstOrCreate([
            'language' => $code,
            'counter_id' => $id,
        ]);

        $counterTranslation->title = $request->title;
        $counterTranslation->save();

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->route('admin.counter.index')->with($notification);
    }
}
