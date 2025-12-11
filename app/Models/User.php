<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser, HasName
{
    use HasFactory, Notifiable;

    protected $table = 'login';

    protected $primaryKey = 'account_id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'userid',
        'user_pass',
        'email',
        'has_partner',
        'birthdate',
    ];

    protected $casts = [
        'has_partner' => 'boolean',
        'birthdate'   => 'date',      // salva em Y-m-d
        'lastlogin'   => 'datetime',  // opcional, para a coluna da tabela
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return $this->group_id == 99;
    }

    public function getFilamentName(): string
    {
        return "$this->userid";
    }
}
