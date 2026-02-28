<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogTranslationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function create($language, $blogID)
    {
        $blog = Blog::findOrFail($blogID);
        $blogData = [];
        $blogData['language'] = $language;
        $blogData['blog_id'] = $blogID;
        $data = [];
        $data['blog'] = BlogTranslation::firstOrCreate($blogData);

        if (strtolower($language) === strtolower('en')) {
            $blogData['title'] = $blog->title;
            $blogData['description'] = $blog->description;
            $blogData['seo_title'] = $blog->seo_title;
            $blogData['seo_description'] = $blog->seo_description;
            $data['blog']->update($blogData);

            $notification = trans("admin_validation.Updated Successfully");

            $notification = ["messege" => $notification, "alert-type" => "success"];

            return redirect()->route('admin.blog.index')->with($notification);
        }

        return view('admin.blog-translation-create', $data);
    }

    public function update(Request $request)
    {
        if (strtolower($request->language) === strtolower('en')) {
            return redirect()->route('admin.blog.edit', $request->blog_id);
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

        $blogTranslation = BlogTranslation::firstOrCreate([
            'language' => $request->language,
            'blog_id' => $request->blog_id,
        ]);

        $blogTranslation->title = $request->title;
        $blogTranslation->description = $request->description;
        $blogTranslation->seo_title = $request->seo_title ? $request->seo_title : $request->title;
        $blogTranslation->seo_description = $request->seo_description ? $request->seo_description : $request->title;
        $blogTranslation->save();

        $notification = trans('admin_validation.Updated Successfully');
        $notification = array('messege' => $notification, 'alert-type' => 'success');
        return redirect()->back()->with($notification);
    }
}
