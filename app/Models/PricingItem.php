<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PricingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'default_unit',
        'related_work_id',
    ];

    public function relatedWork(): BelongsTo
    {
        return $this->belongsTo(RelatedWork::class);
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(PricingItemSpecification::class);
    }

    public function projectItems(): HasMany
    {
        return $this->hasMany(ProjectPricingItem::class);
    }
}