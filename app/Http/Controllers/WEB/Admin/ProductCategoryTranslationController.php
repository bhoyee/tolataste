<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductCategoryTranslation;
use Illuminate\Http\Request;

class ProductCategoryTranslationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function create($code, $id)
    {
        $category = Category::findOrFail($id);

        $categoryData = [];
        $categoryData['language'] = $code;
        $categoryData['category_id'] = $id;

        $data = [];
        $data['category'] = ProductCategoryTranslation::firstOrCreate($categoryData);

        if (strtolower($code) === strtolower('en')) {
            $data['category']->name = $category->name;
            $data['category']->save();

            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];

            return redirect()->route('admin.product-category.index')->with($notification);
        }

        return view('admin.product-category-translation-create', $data);
    }

    public function update(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        if (strtolower($request->language) === strtolower('en')) {
            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];

            return redirect()->route('admin.product-category.index')->with($notification);
        }

        $categoryTranslation = ProductCategoryTranslation::firstOrCreate([
            'language' => $request->language,
            'category_id' => $request->category_id,
        ]);

        $categoryTranslation->name = $request->name;
        $categoryTranslation->save();

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
