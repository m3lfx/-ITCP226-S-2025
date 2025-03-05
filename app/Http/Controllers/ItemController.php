<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Stock;
use App\Models\Order;
use App\Models\Customer;
use App\Imports\ItemsImport;
use App\Imports\ItemStockImport;
use App\Cart;
use Validator;
use Storage;
use DB;
use Excel;
use Session;
use Carbon\Carbon;
use Auth;


class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $items = Item::all();
       
         $items = DB::table('item')->join('stock', 'item.item_id', '=', 'stock.item_id')->get();
        return view('item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('item.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);

        $rules = [
            'description' => 'required|min:4',
            'image' => 'mimes:jpg,png'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $path = Storage::putFileAs(
            'public/images',
            $request->file('image'),
            $request->file('image')->hashName()
        );

        $item = Item::create([
            'description' => trim($request->description),
            'cost_price' => $request->cost_price,
            'sell_price' => $request->sell_price,
            'image' => $path
        ]);

        $stock = new Stock();
        $stock->item_id = $item->item_id;
        $stock->quantity = $request->qty;
        $stock->save();
        return redirect()->back()->with('success', 'item added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $item = Item::find($id);
        // $stock = Stock::find($id);
        $item = DB::table('item')
                ->join('stock', 'item.item_id', '=', 'stock.item_id')
                ->where('item.item_id',$id)
                ->first();
        // dd($item);
        // return view('item.edit', compact('item', 'stock'));
        return view('item.edit', compact('item'));
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

    public function import()
    {
      
        Excel::import(
            new ItemStockImport,
            request()
                ->file('item_upload')
                ->storeAs(
                    'files',
                    request()
                        ->file('item_upload')
                        ->getClientOriginalName()
                )
        );
        return redirect()->back()->with('success', 'Excel file Imported Successfully');
    }

    public function getItems()
    {
        $items = DB::table('item')->join('stock', 'item.item_id', '=', 'stock.item_id')->get();
      
       
        return view('shop.index', compact('items'));
    }

    public function addToCart($id)
    {
        $item = Item::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // dd($oldCart);
        $cart = new Cart($oldCart);
        // dd($cart);
        $cart->add($item, $id);

        Session::put('cart', $cart);
        // dump(Session::get('cart'));
        // $request->session()->save();
        // Session::save();
        // dd(Session::get('cart'));

        return redirect('/')->with('success', 'item added to cart');
    }

    public function getCart()
    {
        // dump(Session::get('cart'));
        if (!Session::has('cart')) {
            return view('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        // dd($cart);
        return view('shop.shopping-cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }

    public function getReduceByOne($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return redirect()->route('getCart');
    }

    public function getRemoveItem($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        } else {
            Session::forget('cart');
        }
        return redirect()->route('getCart');
    }

    public function postCheckout(){
        if (!Session::has('cart')) {
            return redirect()->route('getCart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        // dd($cart->items);
        try {
            DB::beginTransaction();
            $order = new Order();
            $customer =  Customer::where('user_id', Auth::id())->first();
            // $order->customer_id = $customer->customer_id;
            $order->customer_id = $customer->customer_id;
            $order->date_placed = now();
            $order->date_shipped = Carbon::now()->addDays(5);
        
            $order->shipping = 10.00  ;
            $order->status = 'pending';
            $order->save();
            
    	    foreach($cart->items as $items){
        		$id = $items['item']['item_id'];
               
                DB::table('orderline')->insert(
                    ['item_id' => $id, 
                     'orderinfo_id' => $order->orderinfo_id,
                     'quantity' => $items['qty']
                    ]
                    );
        		
                $stock = Stock::find($id);
          		$stock->quantity = $stock->quantity - $items['qty'];
         		$stock->save();
            }
            // dd($order);
        }
        catch (\Exception $e) {
            // dd($e->getMessage());
	        DB::rollback();
        
            return redirect()->route('getCart')->with('error', $e->getMessage());
        }
    
        DB::commit();
        Session::forget('cart');
        return redirect('/')->with('success','Successfully Purchased Your Products!!!');
    }
}
