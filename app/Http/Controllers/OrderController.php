<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Order;
use App\Mail\SendOrderStatus;
use Mail;


class OrderController extends Controller
{
    public function processOrder($id)
    {
        $customer = DB::table('customer as c')
            ->join('orderinfo as o', 'o.customer_id', '=', 'c.customer_id')
            ->where('o.orderinfo_id', $id)
            ->select('c.lname', 'c.fname', 'c.addressline', 'c.phone', 'o.orderinfo_id',  'o.status', 'o.date_placed')
            ->first();
        // dd($customer);
        $orders = DB::table('customer as c')
            ->join('orderinfo as o', 'o.customer_id', '=', 'c.customer_id')
            ->join('orderline as ol', 'o.orderinfo_id', '=', 'ol.orderinfo_id')
            ->join('item as i', 'ol.item_id', '=', 'i.item_id')
            ->where('o.orderinfo_id', $id)
            ->select('i.description', 'ol.quantity', 'i.image', 'i.sell_price')
            ->get();
        // dd($orders);
        $total = $orders->map(function ($item, $key) {
            return $item->sell_price * $item->quantity;
        })->sum();
        // dd($total);
        return view('order.processOrder', compact('customer', 'orders', 'total'));
    }

    public function orderUpdate(Request $request, $id)
    {
        // dd($request);
        $order = Order::where('orderinfo_id', $id)
            ->update(['status' => $request->status]);
        // dd($order);
        // dd($user->id);

        // dd($order > 0);
        if ($order > 0) {
            $myOrder = DB::table('customer as c')
                ->join('orderinfo as o', 'o.customer_id', '=', 'c.customer_id')
                ->join('orderline as ol', 'o.orderinfo_id', '=', 'ol.orderinfo_id')
                ->join('item as i', 'ol.item_id', '=', 'i.item_id')
                ->where('o.orderinfo_id', $id)
                ->select('c.user_id', 'i.description', 'ol.quantity', 'i.image', 'i.sell_price')
                ->get();
            // dd($myOrder);
            $user =  DB::table('users as u')
                ->join('customer as c', 'u.id', '=', 'c.user_id')
                ->join('orderinfo as o', 'o.customer_id', '=', 'c.customer_id')
                ->where('o.orderinfo_id', $id)
                ->select('u.id', 'u.email')
                ->first();
            // dd($user);
            Mail::to($user->email)
                ->send(new SendOrderStatus($myOrder));
            return redirect()->route('admin.orders')->with('success', 'order updated');
        }
        // return redirect()->route('admin.orders')->with('success', 'order updated');

        redirect()->route('admin.orders')->with('error', 'email not sent');
    }
}
