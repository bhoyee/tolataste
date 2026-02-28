<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\CategoryTranslation;
use Illuminate\Http\Request;

class CategoryTranslationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function create($language, $id)
    {
        $category = BlogCategory::findOrFail($id);

        $categoryData = [];
        $categoryData['language'] = $language;
        $categoryData['category_id'] = $id;

        $data = [];
        $data['category'] = CategoryTranslation::firstOrCreate($categoryData);

        if (strtolower($language) === strtolower('en')) {
            $data['category']->name = $category->name;
            $data['category']->save();
            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];

            return redirect()->route('admin.blog-category.index')->with($notification);
        }

        return view('admin.blog-category-translation-create', $data);
    }

    public function update(Request $request)
    {

        if (strtolower($request->language) === strtolower('en')) {
            return redirect()->route('admin.blog-category.edit', $request->category_id);
        }

        $rules = [
            'name' => 'required',
        ];
        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        $categoryTranslation = CategoryTranslation::firstOrCreate([
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
