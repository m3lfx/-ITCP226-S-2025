<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Searchable\Search;
use App\Models\Item;
use App\Models\Customer;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // dd($request->term);
        $searchResults = (new Search())
            ->registerModel(Customer::class, 'lname', 'fname', 'addressline')
            ->registerModel(Item::class, 'description')
            ->search(trim($request->term));

            // dd($searchResults);
            return view('search', compact('searchResults'));
    }
}
