<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemDelivery extends Model
{
    protected $fillable = [
        'pack_id',
        'store_id',
        'account_id',
        'item_id',
        'item_quantity',
        'collected_at',
    ];
}
