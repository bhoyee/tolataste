<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceTranslation;
use Illuminate\Http\Request;

class ServiceTranslationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function create($code, $id)
    {
        $serviceNT = Service::findOrFail($id);

        $data['language'] = $code;

        $serviceData = [];
        $serviceData['language'] = $code;
        $serviceData['service_id'] = $serviceNT->id;
        $data['service'] = ServiceTranslation::firstOrCreate($serviceData);
        $isDefaule = false;

        if (strtolower($code) === strtolower('en')) {
            $serviceData['title'] = $serviceNT->title;
            $serviceData['description'] = $serviceNT->description;
            $data['service']->update($serviceData);
            $isDefaule = true;
        }


        if ($isDefaule) {
            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];
            return redirect()->route('admin.service.index')->with($notification);
        }

        return view('admin.service-translation', $data);
    }

    public function update(Request $request, $code, $id)
    {
        if (strtolower($code) === strtolower('en')) {
            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];
            return redirect()->route('admin.service.index')->with($notification);
        }

        $rules = [
            'title' => 'required',
            'description' => 'required',
        ];

        $customMessages = [
            'title.required' => trans('admin_validation.Title is required'),
            'description.required' => trans('admin_validation.description is required'),
        ];

        $validatedData = $this->validate($request, $rules, $customMessages);

        $serviceTranslation = ServiceTranslation::firstOrCreate([
            'language' => $code,
            'service_id' => $id,
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
