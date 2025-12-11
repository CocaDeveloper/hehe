<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayoutBalance extends Model
{
    const STATUS_CREATED = 'created';
    const STATUS_PENDING = 'pending';
    const STATUS_FAILED = 'failed';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'account_id',
        'transaction_id',
        'value',
        'pix_key',
        'owner_name',
        'owner_tax_id',
        'bank_name',
        'status',
        'created_at',
    ];
}
