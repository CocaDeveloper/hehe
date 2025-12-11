<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DonateClient extends Model
{
    protected $table = 'donate_client';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'cpf',
        'phone',
        'account_id'
    ];

    public function history(): HasMany
    {
        return $this->hasMany(DonateHistory::class);
    }
}
