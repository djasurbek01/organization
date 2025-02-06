<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phones', 'building_id'];

    protected $casts = [
        'phones' => 'array',
    ];

    public function building():BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function activities():BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'organization_activity');
    }
}
