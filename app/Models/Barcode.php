<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barcode extends Model
{
    use HasFactory;
    protected $table = 'barcode';
    protected $primaryKey = 'barcode_ean';
    public $timestamps = false;
}
