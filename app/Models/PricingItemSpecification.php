<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PricingItemSpecification extends Model
{
    use HasFactory;

    protected $fillable = [
        'pricing_item_id',
        'name',
    ];

    public function pricingItem(): BelongsTo
    {
        return $this->belongsTo(PricingItem::class);
    }
}