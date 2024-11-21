<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'unit'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function priceDetails(){
        return $this->hasMany(PriceDetail::class);
    }
}
