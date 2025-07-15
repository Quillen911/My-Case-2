<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use App\Models\CartItem;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{
    public function cart(Request $request)
    {
        $user = auth()->user();
        $cart = Cart::where('Cart_User_id', $user->id)->first();
        $products = $cart ? $cart->cartItem()->with('product.category')->get() : collect();
        return view('cart', compact('products'));
    }
    public function add(Request $request)
    {
        
        $user = auth()->user(); 
        $cart = Cart::firstOrCreate(['Cart_User_id' => $user->id]);

        $productItem = $cart->cartItem()->where('product_id', $request->product_id)->first();
        $product = Product::find($request->product_id);
        
        if ($product->stock_quantity == 0) {
            return redirect('main')->with('error', 'Ürün stokta yok!');

        } else if ($productItem) {
            $productItem->quantity += 1;
            $productItem->save();
            $product->stock_quantity -= 1;
            $product->save();

        } else {
            $cart->cartItem()->create([
                'product_id' => $request->product_id,
                'quantity' => 1
            ]);
            $product->stock_quantity -= 1;
            $product->save();

        }
        Cache::flush(); 
        return redirect()->route('main')->with('success', 'Ürün sepete eklendi!');
    }
    public function delete($id)
    {   
        $cartItem = CartItem::find($id);

        if ($cartItem) {
            $product = Product::find($cartItem->product_id);
            if ($product) {
                $product->stock_quantity += 1;
                $product->save();
            }

            if ($cartItem->quantity > 1) {
                $cartItem->quantity -= 1;
                $cartItem->save();
            } else {
                $cartItem->delete();
            }
        }

        Cache::flush(); 
        return redirect()->route('cart')->with('success', 'Ürün sepetten 1 adet silindi!');
    }
}