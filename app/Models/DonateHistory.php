<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonateHistory extends Model
{
    protected $table = 'donate_history';
    const PAYMENT_METHOD_PIX = 'pix';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'reference',
        'status',
        'value',
        'payment_method',
        'token',
        'client_id',
        'partner_id',
        'store_id',
        'pack_id',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(DonateClient::class, 'client_id', 'id');
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id', 'account_id')->where('has_partner', true);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function pack(): BelongsTo
    {
        return $this->belongsTo(Pack::class);
    }
}
