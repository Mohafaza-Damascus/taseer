<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contractor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'national_number',
        'birth_date',
        'company_name',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}