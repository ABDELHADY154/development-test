<?php

namespace App\Http\Controllers;

use AElnemr\RestFullResponse\CoreJsonResponse;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    use CoreJsonResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
    public function getOrder($orderid)
    {
        $order = Order::find($orderid);
        if ($order) {
            return $this->ok((new OrderResource($order))->resolve());
        }
        return $this->notFound(['order not found']);
    }
    public function getUsersOrder(Request $request)
    {
        $request->validate([
            'userid' => ['required', 'exists:users,id']
        ]);

        $user = User::find($_GET['userid']);
        if ($user) {

            return $this->ok(['orders' => OrderResource::collection($user->orders)->resolve()]);
        }
        return $this->notFound(['user not found']);
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'userid' => ['required', 'exists:users,id'],
            'paymentid' => ['required', 'exists:payments,id'],
            'products' => ['required', 'array'],
        ]);
        if (count($request->products) >= 1) {
            $totalPrice = 0;
            foreach ($request->products as $pr) {
                $product = Product::find($pr['productid']);
                $totalPrice += $product->price;
            }
            $order = Order::create([
                'user_id' => $request->userid,
                'payment_id' => $request->paymentid,
                'price' => $totalPrice,
            ]);
            foreach ($request->products as $pr) {
                $product = Product::find($pr['productid']);
                $product->orders()->attach($product->id, ['order_id' => $order->id]);
            }
            return $this->created((new OrderResource($order))->resolve());
        }

        return $this->notFound(['products not found']);
    }
    public function updateOrder(Request $request, $orderid)
    {

        $request->validate([
            'userid' => ['required', 'exists:users,id'],
            'paymentid' => ['required', 'exists:payments,id'],
            // 'products' => ['nullable', 'array'],
        ]);
        $order = Order::find($orderid);
        $order->update(['payment_id' => $request->paymentid, 'user_id' => $request->userid]);
        $order->save();
        return $this->created((new OrderResource($order))->resolve());
    }
}
