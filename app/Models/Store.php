<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'item_id',
        'quantity',
        'value',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(ItemDatabase::class, 'item_id');
    }
}
