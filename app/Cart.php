<?php

namespace App;

class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;
    public function __construct($oldCart)
    {
        if ($oldCart) {

            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
            // dd($this->items);
        }
    }

    public function add($item, $id)
    {
        // dd($this->items, $item, $id);
        $storedItem = ['qty' => 0, 'price' => $item->sell_price, 'item' => $item];
        // dd($storedItem, $this->items);
        
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }
        // dd($storedItem);
        //$storedItem['qty'] += $item->qty;
        $storedItem['qty']++;
        $storedItem['price'] = $item->sell_price * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalQty++;
        $this->totalPrice += $storedItem['price'];
        // dd($this);

    }

    public function reduceByOne($id)
    {
        $this->items[$id]['qty']--;
        $this->items[$id]['price'] -= $this->items[$id]['item']['sell_price'];
        $this->totalQty--;
        $this->totalPrice -= $this->items[$id]['item']['sell_price'] * $this->items[$id]['qty'];
        if ($this->items[$id]['qty'] <= 0) {
            unset($this->items[$id]);
        }
    }
}