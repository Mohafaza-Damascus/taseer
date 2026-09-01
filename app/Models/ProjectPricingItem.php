<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectPricingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'pricing_item_id',
        'quantity',
        'unit',
        'unit_price_syp',
        'unit_price_usd',
        'specifications',
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'unit_price_syp' => 'decimal:2',
        'unit_price_usd' => 'decimal:2',
        'specifications' => 'array',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function pricingItem(): BelongsTo
    {
        return $this->belongsTo(PricingItem::class);
    }
}