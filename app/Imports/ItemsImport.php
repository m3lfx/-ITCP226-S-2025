<?php

namespace App\Imports;

use App\Models\Item;
use App\Models\Stock;
use Maatwebsite\Excel\Concerns\ToModel;

class ItemsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $item =  Item::create([
            'description' => $row[0],
            'cost_price' => $row[1],
            'sell_price' => $row[2],
            'image' => 'default.jpg',
        ]);

        // dd($item);

        $stock = new Stock();
        $stock->item_id = $item->item_id;
        $stock->quantity = $row[3];
        $stock->save();
    }
}
