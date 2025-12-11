<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemDatabase extends Model
{
    protected $table = 'item_db';

    public $timestamps = false;

    private static array $types = [
        'Ammo'         => 'Munição',
        'Armor'        => 'Equipamento',
        'Card'         => 'Carta',
        'Cash'         => 'Loja de Cash',
        'Delayconsume' => 'Consumível',
        'Etc'          => 'Etc',
        'Healing'      => 'Cura',
        'Petarmor'     => 'Equipamento de Pet',
        'Petegg'       => 'Ovo de Pet',
        'Shadowgear'   => 'Equipamento Sombrio',
        'Usable'       => 'Utilizável',
        'Weapon'       => 'Arma',
    ];

    private static array $typesAndSubtypes = [
        'Weapon' => [
            '1hAxe'   => 'Machado de Uma Mão',
            '1hSpear' => 'Lança de Uma Mão',
            '1hWword' => 'Espada de Uma Mão',
            '2hAxe'   => 'Machado de Duas Mãos',
            '2hSpear' => 'Lança de Duas Mãos',
            '2hStaff' => 'Cajado de Duas Mãos',
            '2hSword' => 'Espada de Duas Mãos',
            'Book'     => 'Livro',
            'Bow'      => 'Arco',
            'Dagger'   => 'Adaga',
        ],
        'Ammo' => [
            'Arrow' => 'Flecha',
            'Bullet'     => 'Bala',
            'Cannonball' => 'Bala de Canhão',
        ],
        'Card' => [
            'Normal'  => 'Carta',
            'Enchant' => 'Carta Encantada',
        ],
    ];

    private array $tradeOptions = [
        'trade_nodrop'        => 'Não pode ser descartado',
        'trade_notrade'       => 'Não pode ser negociado com jogadores',
        'trade_tradepartner'  => 'Não pode ser negociado com parceiro',
        'trade_nosell'        => 'Não pode ser vendido para NPC',
        'trade_nocart'        => 'Não pode ser colocado no Carrinho',
        'trade_nostorage'     => 'Não pode ser armazenado',
        'trade_noguildstorage'=> 'Não pode ser armazenado no Depósito da Guilda',
        'trade_nomail'        => 'Não pode ser anexado em cartas',
        'trade_noauction'     => 'Não pode ser leiloado',
    ];

    private array $jobs = [
        'job_all'           => 'Todas as Classes',
        'job_novice'        => 'Aprendiz',
        'job_supernovice'   => 'Super Aprendiz',
        'job_swordman'      => 'Espadachim',
        'job_mage'          => 'Mago',
        'job_archer'        => 'Arqueiro',
        'job_acolyte'       => 'Acólito',
        'job_merchant'      => 'Mercador',
        'job_thief'         => 'Gatuno',
        'job_knight'        => 'Cavaleiro',
        'job_priest'        => 'Sacerdote',
        'job_wizard'        => 'Bruxo',
        'job_blacksmith'    => 'Ferreiro',
        'job_hunter'        => 'Caçador',
        'job_assassin'      => 'Algoz',
        'job_crusader'      => 'Templário',
        'job_monk'          => 'Monge',
        'job_sage'          => 'Sábio',
        'job_rogue'         => 'Desordeiro',
        'job_alchemist'     => 'Alquimista',
        'job_barddancer'    => 'Bardo / Cigana',
        'job_taekwon'       => 'Taekwon',
        'job_stargladiator' => 'Justiceiro Estelar',
        'job_soullinker'    => 'Espiritualista',
        'job_gunslinger'    => 'Justiceiro',
        'job_ninja'         => 'Ninja',
    ];

    private array $locations = [
        'location_head_low'               => 'Baixo',
        'location_right_hand'             => 'Mão Principal',
        'location_garment'                => 'Capa',
        'location_right_accessory'        => 'Acessório Direito',
        'location_armor'                  => 'Armadura',
        'location_left_hand'              => 'Mão Secundária',
        'location_shoes'                  => 'Calçados',
        'location_left_accessory'         => 'Acessório Esquerdo',
        'location_head_top'               => 'Topo',
        'location_head_mid'               => 'Meio',
        'location_costume_head_top'       => 'Visual Topo',
        'location_costume_head_mid'       => 'Visual Meio',
        'location_costume_head_low'       => 'Visual Baixo',
        'location_costume_garment'        => 'Visual Capa',
        'location_ammo'                   => 'Munição',
        'location_shadow_armor'           => 'Armadura Sombria',
        'location_shadow_weapon'          => 'Arma Sombria',
        'location_shadow_shield'          => 'Escudo Sombrio',
        'location_shadow_shoes'           => 'Calçados Sombrios',
        'location_shadow_right_accessory' => 'Acessório Sombrio Direito (Brinco)',
        'location_shadow_left_accessory'  => 'Acessório Sombrio Esquerdo (Cólar)',
    ];

    public function getType()
    {
        return self::$types[$this->type] ?? null;
    }

    public static function getAllTypes(): array
    {
        return self::$types;
    }

    public function getSubtypes(): ?string
    {
        return self::$typesAndSubtypes[$this->type][$this->subtype] ?? null;
    }

    public function getTradeRestrictions(): array
    {
        return array_values(array_filter($this->tradeOptions, function ($key) {
            return $this->$key === 1;
        }, ARRAY_FILTER_USE_KEY));
    }

    public function getJobs(): array
    {
        return array_values(array_filter($this->jobs, function ($key) {
            return $this->$key === 1;
        }, ARRAY_FILTER_USE_KEY));
    }

    public function getLocations(): array
    {
        return array_values(array_filter($this->locations, function ($key) {
            return $this->$key === 1;
        }, ARRAY_FILTER_USE_KEY));
    }
}
