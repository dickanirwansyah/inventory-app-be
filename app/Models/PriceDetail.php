<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceDetail extends Model
{
    use HasFactory;

    protected $fillable = ['price_id', 'tier', 'price'];

    public function price(){
        return $this->belongsTo(Price::class);
    }
}
