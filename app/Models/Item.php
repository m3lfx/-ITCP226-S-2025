<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;


class Item extends Model implements Searchable
{
    use HasFactory;
    protected $table = 'item';
    protected $primaryKey = 'item_id';
    // public $timestamps = false;
    protected $fillable = ['description', 'cost_price', 'sell_price', 'image'];
    public function getSearchResult(): SearchResult
    {
       $url = route('items.edit', $this->item_id);
    
        return new \Spatie\Searchable\SearchResult(
           $this,
           $this->description,
           $url
        );
    }
}
