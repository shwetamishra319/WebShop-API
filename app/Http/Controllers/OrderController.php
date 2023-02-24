<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\OrderPaymentRequest;
use App\Http\Requests\CreateOrderRequest;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::paginate(50);
        return response()->json($order, 200);
    }

    public function store(CreateOrderRequest $request)
    {
        try{
            $order = new App\Models\Order;
            $order->customer_id = $request->input('customer_id');
            $order->save();
    
            foreach ($request->input('products') as $product) {
                $productModel = App\Models\Product::findOrFail($product['product_id']);
                $order->products()->attach($productModel->id, ['quantity' => $product['quantity']]);
            }
            return response()->json($order, 200);
        }catch(\Exception $e) {
            return response()->json(trans('api_messages.failure'));
        }
    }

    public function show($id)
    {
        try{
            $order = Order::findOrFail($id);
            return response()->json($order, 200);
        }catch(\Exception $e) {
            return response()->json(trans('api_messages.no_record'));
        }
    }

    public function update(Request $request, $id)
    {
        try{
            $order = Order::findOrFail($id);
            $order->update($request->all());
            return response()->json($order, 200);
        }catch(\Exception $e) {
            return response()->json(trans('api_messages.no_record'));
        }
    }

    public function destroy($id)
    {
        try{
            Order::findOrFail($id)->delete();
            return response()->json(trans('api_messages.order.delete'));
        }catch(\Exception $e) {
            return response()->json(trans('api_messages.no_record'));
        }
    }

    public function addNewProductInOrder($id, AddProductRequest $request) {
        try{
            $order = Order::findOrFail($id);
            if ($order->payed) {
                return response()->json(trans('api_messages.order.already_paid'));
            }
            $product_id = $request->input('product_id');
            $product = Product::findOrFail($product_id);
            $order->products()->attach($product->id);
            return response()->json(trans('api_messages.order.product_added'));
        }catch(\Exception $e){
            return response()->json(trans('api_messages.no_record'));
        }
    }

    public function makePayment($id, OrderPaymentRequest $request) {

        $order = Order::findOrFail($id);
        if ($order->payed) {
            return response()->json(trans('api_messages.order.already_paid'));
        }
        $response = Http::post('https://superpay.view.agentur-loop.com/pay', [
            'order_id' => $order->id,
            'customer_email' => $order->customer->email,
            'value' => $order->totalPrice()
        ]);
        if ($response->ok()) {
            $order->payed = true;
            $order->save();
            return response()->json(['message' => 'Payment Successful']);
        }
        return response()->json(['message' => 'Insufficient Funds']);
    }
}
