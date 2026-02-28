<?php

namespace App\Http\Controllers\WEB\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductTranslation;
use Illuminate\Http\Request;

class ProductTranslationController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:admin");
    }

    public function create($code, $id)
    {
        $product = Product::findOrFail($id);

        $data['language'] = $code;

        $productData = [];
        $productData['language'] = $code;
        $productData['product_id'] = $product->id;
        $data['productTranslation'] = ProductTranslation::firstOrCreate($productData);
        $isDefaule = false;

        if (strtolower($code) === strtolower('en')) {
            $productData['name'] = $product->name;
            $productData['short_description'] = $product->short_description;
            $productData['long_description'] = $product->long_description;
            $productData['seo_title'] = $product->seo_title;
            $productData['seo_description'] = $product->seo_description;

            $data['productTranslation']->update($productData);

            $isDefaule = true;
        }

        if ($isDefaule) {
            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];

            return redirect()->route('admin.product.index')->with($notification);
        }

        return view('admin.product-translation', $data);
    }

    public function update(Request $request, $code, $id)
    {
        if (strtolower($code) === strtolower('en')) {
            $notification = trans("admin_validation.Updated Successfully");
            $notification = ["messege" => $notification, "alert-type" => "success"];

            return redirect()->route('admin.product.index')->with($notification);
        }

        $rules = [
            'name' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'seo_title' => 'nullable',
            'seo_description' => 'nullable',
        ];

        $customMessages = [
            'name.required' => trans('admin_validation.Name is required'),
            'short_description.required' => trans('admin_validation.Short description is required'),
            'long_description.required' => trans('admin_validation.Long description is required'),
        ];

        $validatedData = $this->validate($request, $rules, $customMessages);

        $productTranslation = ProductTranslation::firstOrCreate([
            'language' => $code,
            'product_id' => $id,
        ]);

        $productTranslation->update($validatedData);

        if ($productTranslation->update($validatedData)) {
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
