<?php

namespace App\Http\Controllers\WEB\Admin;
use Illuminate\Support\Facades\Log;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductVariantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // Show all variants

    public function index($productId)
    {
        $product = Product::find($productId);

        if ($product) {
            $size_variant = json_decode($product->size_variant) ?? [];
            $optional_item = json_decode($product->optional_item) ?? [];
            $protein_item = json_decode($product->protein_item) ?? [];

                // NEW: decode soup, wrap, drink
            $soup_item = json_decode($product->soup_item) ?? [];
            $wrap_item = json_decode($product->wrap_item) ?? [];
            $drink_item = json_decode($product->drink_item) ?? [];

            return view('admin.variant', compact(
                'size_variant',
                'optional_item',
                'protein_item',
                'soup_item',
                'wrap_item',
                'drink_item',
                'product'
            ));
        }

        $notification = trans('admin_validation.Something went wrong');
        return redirect()->route('admin.product.index')->with([
            'messege' => $notification,
            'alert-type' => 'error',
        ]);
    }


    // Store size variant
    public function store(Request $request, $id)
    {
        if (count($request->sizes) > 0) {
            $size_variant = [];

            foreach ($request->sizes as $index => $size) {
                if (!empty($size) && !empty($request->prices[$index])) {
                    $size_variant[] = [
                        'size' => $size,
                        'price' => $request->prices[$index],
                    ];
                }
            }

            $product = Product::find($id);
            $product->size_variant = json_encode($size_variant);
            $product->save();
        }

        return redirect()->back()->with([
            'messege' => trans('admin_validation.Inserted Successfully'),
            'alert-type' => 'success',
        ]);
    }

    // Store optional item or protein based on type

    public function store_optional_item(Request $request, $id)
    {
        $items = [];
    
        if (is_array($request->item_names) && count($request->item_names) > 0) {
            foreach ($request->item_names as $index => $name) {
                if (!empty($name) && isset($request->item_prices[$index]) && $request->item_prices[$index] !== null) {
                    $items[] = [
                        'item' => $name,
                        'price' => $request->item_prices[$index],
                    ];
                }
            }
        }
    
        $product = Product::find($id);
    
        // Decide where to store the data based on type
        switch ($request->type) {
            case 'protein':
                $product->protein_item = count($items) ? json_encode($items) : null;
                break;
            case 'soup':
                $product->soup_item = count($items) ? json_encode($items) : null;
                break;
            case 'wrap':
                $product->wrap_item = count($items) ? json_encode($items) : null;
                break;
            case 'drink':
                $product->drink_item = count($items) ? json_encode($items) : null;
                break;
            default:
                $product->optional_item = count($items) ? json_encode($items) : null;
                break;
        }
    
        $product->save();
    
        return redirect()->back()->with([
            'messege' => trans('admin_validation.Inserted Successfully'),
            'alert-type' => 'success',
        ]);
    }
    
    



}
