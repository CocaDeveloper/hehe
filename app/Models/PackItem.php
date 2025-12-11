<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackItem extends Model
{
    protected $fillable = [
        'pack_id',
        'item_id',
        'quantity',
    ];

    public function pack(): BelongsTo
    {
        return $this->belongsTo(Pack::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(ItemDatabase::class, 'item_id');
    }
}
