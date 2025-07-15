<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bag;
use App\Models\BagItem;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class OrderController extends Controller
{
    public function order()
    {
        $user = auth()->user();
        $bag = Bag::where('Bag_User_id', $user->id)->first();
        $products = $bag ? $bag->bagItem()->with('product.category')->get() : collect();
        return view('order', compact('products'));
    }
    public function ordergo(Request $request)
    {
        $user = auth()->user();
        $bag = Bag::firstOrCreate(['Bag_User_Id' => $user->id]);
        $productItem = $bag->bagItem()->where('product_id', $request->product_id)->first();
        $product = Product::find($request->product_id);

    }

}