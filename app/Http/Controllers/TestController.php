<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart; // Or whatever your Cart facade/class is
use App\Models\Product; // Add this if you need Product model
use Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException;
use Illuminate\Support\Facades\Mail;



class TestController extends Controller
{
    public function getTestData($rowId)
    {
        \Log::info("✅ TestController::getTestData called with rowId: " . $rowId);
        return response()->json(['message' => 'This is from TestController!', 'rowId' => $rowId]);
    }


    public function getCartItemDetails($rowId)
    {
        try {
            Log::debug("✅ getCartItemDetails called with rowId: " . $rowId);

            $cartItem = \Cart::get($rowId);

            if (!$cartItem) {
                Log::warning("⚠️ Cart item not found for rowId: " . $rowId);
                return response()->json(['message' => 'Item not found in cart'], 404);
            }

            // Normalize protein items (example - adapt to your data structure)
            $selectedProteins = collect($cartItem->options->protein_items ?? [])
                ->map(function ($item) {
                    return [
                        'protein_name' => $item['protein_name'] ?? '',
                        'price' => $item['price'] ?? 0,
                    ];
                })
                ->toArray() ?? [];

            // Example: Fetch available sizes from the database (adapt to your model!)
            // $availableSizes = \App\Models\Size::all()->toArray();
            $availableSizes = [
                ['name' => 'Small', 'price' => 0],
                ['name' => 'Medium', 'price' => 2],
                ['name' => 'Large', 'price' => 4],
            ]; // Hardcoded for demonstration

            $cartItemData = [
                'rowId' => $cartItem->rowId,
                'id' => $cartItem->id,
                'name' => $cartItem->name,
                'qty' => $cartItem->qty,
                'price' => $cartItem->price,
                'options' => (array) $cartItem->options,
                'selectedProteins' => $selectedProteins,
                'availableProteins' => $availableProteins, // Include available sizes
                'currency_icon' => config('currency.icon', '$'),
            ];

            Log::info("✅ Cart Item Data (final):", $cartItemData);

            return response()->json(['cartItem' => $cartItemData]);

        } catch (\Exception $e) {
            Log::error('❌ Error getting cart item details: ' . $e->getMessage(), ['rowId' => $rowId]);
            return response()->json(['message' => 'Server error'], 500);
        }
    }

    public function editCartPage($rowId)
    {
        try {
            $cartItem = Cart::get($rowId);
    
            if (!$cartItem) {
                return redirect()->route('cart')->with('error', 'This cart item no longer exists.');
            }
    
            $product = Product::find($cartItem->id);
    
            if (!$product) {
                return redirect()->route('cart')->with('error', 'Product not found.');
            }
    
            $allProteins = $product->protein_item_decoded;
            $allSoups = $product->soup_item_decoded;
            $allWraps = $product->wrap_item_decoded;
            $allDrinks = $product->drink_item_decoded;
            $allOptionals = $product->optional_item ? json_decode($product->optional_item, true) : [];

            
    
            return view('cart.edit-page', compact('cartItem', 'allProteins', 'allSoups', 'allWraps', 'allDrinks', 'allOptionals'));
    
        } catch (\Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException $e) {
            return redirect()->route('cart')->with('error', 'This cart item has already been removed.');
        } catch (\Exception $e) {
            return redirect()->route('cart')->with('error', 'An unexpected error occurred.');
        }
    }
    
   
    public function updateCart(Request $request, $rowId)
    {
        try {
            $cartItem = Cart::get($rowId);
        } catch (InvalidRowIDException $e) {
            return redirect()->route('cart')->with('error', 'This cart item no longer exists.');
        }

        $product = Product::find($cartItem->id);
        if (!$product) {
            return redirect()->route('cart')->with('error', 'Product not found.');
        }

        $finalUnitPrice = (float) $request->input('final_unit_price');
        $finalGrandTotal = (float) $request->input('final_total');

        // Process addons
        $addons = ['proteins', 'soups', 'wraps', 'drinks', 'optionals'];
        $addonData = [];

        foreach ($addons as $type) {
            $selectedItems = $request->input($type, []);
            $processed = [];

            $singular = rtrim($type, 's'); // protein, soup, wrap, drink

            foreach ($selectedItems as $selected) {
                if (!empty($selected)) {
                    list($name, $price) = explode('__', $selected);
                    $processed[] = [
                        "{$singular}_name" => $name,
                        "{$singular}_price" => (float) $price,
                    ];
                }
            }

            // 👇 Save properly with singular key (VERY IMPORTANT)
            $addonData["{$singular}_items"] = $processed;
        }

        // Now create new clean options
        $newOptions = [
            'base_price' => $finalUnitPrice,
            'grand_total' => $finalGrandTotal,
            'food_instruction' => $request->input('food_instruction', ''),
            'slug' => $cartItem->options->slug ?? $product->slug,
            'image' => $cartItem->options->image ?? $product->thumbnail_image,
        ];

        // Add all addon items
        $newOptions = array_merge($newOptions, $addonData);

        Cart::update($rowId, [
            'qty' => $cartItem->qty,
            'price' => $finalUnitPrice,
            'options' => $newOptions,
        ]);

        return redirect()->route('cart')->with('success', 'Cart updated successfully!');
    }


public static function sendOrderSuccessMailStatic($user, $order_result, $method, $payment_status)
{
    try {
        $subject = "Order Confirmation #{$order_result->order_id}";

        // Send to user
        Mail::to($user->email)->send(new \App\Mail\OrderSuccessfully($order_result, $user, $subject));

        // Send to admin (if no changes are required in AdminOrderNotification)
        Mail::to(env('MAIL_ADMIN_ADDRESS'))->send(new \App\Mail\AdminOrderNotification($order_result));

    } catch (\Throwable $e) {
        \Log::error('❌ Email dispatch failed: ' . $e->getMessage());
    }
}

    
    
}