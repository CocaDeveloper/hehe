<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    protected $fillable = [
        'name',
        'price',
    ];

    public function items()
    {
        return $this->hasMany(PackItem::class);
    }
}
