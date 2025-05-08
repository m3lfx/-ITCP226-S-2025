<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $customer = User::find(1)->customer();
        // dd($customer);
        // $user = Customer::find(1)->user;
        // dd($user);
        // $orders = Customer::find(1)->orders;
        // // dd($orders);
        // foreach($orders as $order) {
        //     dump($order->orderinfo_id, $order->date_placed);
        // }

        // $customer = Order::find(2)->customer;
        // dd($customer);
        // foreach($orders as $order) {
        //     dump($order->orderinfo_id, $order->date_placed);
        // }
        // $items = Order::find(1)->items;
        // // dd($items);
        // foreach($items as $item) {
        //     dump($item->description);
        // }
        // $orders = Item::find(1)->orders;
        // // dd($orders);
        // foreach ($orders as $order) {
        //     dump($order->orderinfo_id,  $order->date_placed);
        // }

        // $customers = Customer::with('orders')->get();
        // // dd($customers);
        // foreach ($customers as $customer) {
        //      dump($customer);
        //     foreach($customer->orders as $order) {
        //         dump($order->orderinfo_id, $order->date_placed, $order->status);
        //     }
        // }

        // $orders = Order::with('items')->get();
        // // dd($orders);
        // foreach ($orders as $order) {
        //     dump($order);
        //     // dump($order->orderinfo_id, $order->date_placed, $order->status);
        //     foreach ($order->items as $item) {
        //         dump($item->description);
        //     }
        // }

        // $items = Item::with('orders')->get();
        // // dd($items);
        // foreach ($items as $item) {
        //     dump($item);
        //     // dump($item->description);
        //     foreach ($item->orders as $order) {
        //         dump($order->orderinfo_id, $order->date_placed, $order->status);
        //     }
        // }  

        $orders = Order::with(['customer', 'items'])->get();
        // dd($orders); 
        foreach ($orders as $order) {
            dump($order->customer->lname, $order->customer->fname, $order->customer->addressline, $order->customer->phone);
            dump($order->orderinfo_id, $order->date_placed, $order->status);
            foreach ($order->items as $item) {
                dump($item->description);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::find($id);
        dd($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
