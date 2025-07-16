<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bag;
use App\Models\BagItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use App\Jobs\CreateOrderJob;

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
        $bag = Bag::firstOrCreate(['Bag_User_id' => $user->id]);
        $products = $bag->bagItem()->with('product.category')->orderBy('id')->get();

        foreach($products as $p){
            $productItem = $bag->bagItem()->where('product_id', $p->product_id)->first();
            $orderData = [
                'Bag_User_id' => $user->id,
                'product_id' => $p->product_id,
                'quantity' => $productItem->quantity,
                'price' => $productItem->quantity * $p->product->list_price,
                'status' => 'pending'
            ];
            CreateOrderJob::dispatch($orderData);
        }
        
        $bag->bagItem()->delete();
        return redirect()->route('main')->with('success', 'Siparişiniz işleme alındı!');   
    }

    public function myorders()
    {
        return view('myorders');
    }
    public function CreateOrderJob()
    {
        CreateOrderJob::dispatch();
        return 'Job Kuyruğa eklendi';
    }

}