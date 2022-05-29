<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use App\Models\OrderItem;
use DB;

class OrderController extends Controller
{
    public function index()
    {
        return OrderResource::collection(Order::with('orderItems')->get());
    }

    public function store(Request $request)
    {
        if (!$link = Link::whereCode($request->input('code'))->first()) {
            abort(400, 'Invalid Code');
        }

        try {
            DB::beginTransaction();

            $order = new Order();
            $order->code = $link->code;
            $order->user_id = $link->user->id;
            $order->vendor_email = $link->user->email;
            $order->first_name = $request->input('first_name');
            $order->last_name = $request->input('last_name');
            $order->email = $request->input('email');
            $order->address = $request->input('address');
            $order->city = $request->input('city');
            $order->country = $request->input('country');
            $order->zip = $request->input('zip');

            $order->save();

            foreach ($request->input('products') as $item) {
                $product = Product::find($item['product_id']);

                $orderItem = new OrderItem();

                $orderItem->order_id = $order->id;
                $orderItem->product_title = $product->title;
                $orderItem->price = $product->price;
                $orderItem->quantity = $item['quantity'];
                $orderItem->vendor_revenue = 0.1 * $product->price * $item['quantity'];
                $orderItem->admin_revenue = 0.9 * $product->price * $item['quantity'];

                $orderItem->save();
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'error happened');
        }

        return $order->load('orderItems');
    }
}
