<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'signing_location',
        'start_date',
        'end_date',
        'incoming_entity_id',
        'contractor_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function incomingEntity(): BelongsTo
    {
        return $this->belongsTo(IncomingEntity::class);
    }

    public function contractor(): BelongsTo
    {
        return $this->belongsTo(Contractor::class);
    }

    public function pricingItems(): HasMany
    {
        return $this->hasMany(ProjectPricingItem::class);
    }
}