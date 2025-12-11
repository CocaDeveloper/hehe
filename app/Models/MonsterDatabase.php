<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MonsterDatabase extends Model
{
    protected $table = 'mob_db';

    public $timestamps = false;

    private static array $sizes = [
        'Small'         => 'Pequeno',
        'Medium'        => 'Médio',
        'Large'         => 'Grande',
    ];

    private static array $races = [
        'Formless'		=> 'Amorfo',
        'Undead'		=> 'Morto-Vivo',
        'Brute'		=> 'Bruto',
        'Plant'		=> 'Planta',
        'Insect'		=> 'Inseto',
        'Fish'			=> 'Peixe',
        'Demon'		=> 'Demônio',
        'Demihuman'	=> 'Humanóide',
        'Angel'		=> 'Anjo',
        'Dragon'		=> 'Dragão'
    ];

    private static array $elements = [
        'Neutral' => 'Neutro',
        'Water' => 'Água',
        'Earth' => 'Terra',
        'Fire' => 'Fogo',
        'Wind' => 'Vento',
        'Poison' => 'Veneno',
        'Holy' => 'Sagrado',
        'Dark' => 'Sombrio',
        'Ghost' => 'Fantasma',
        'Undead' => 'Maldito',
    ];

    private array $modes = [
        'mode_aggressive'         => 'Agressivo',
        'mode_angry'              => 'Furioso',
        'mode_assist'             => 'Assistente',
        'mode_canattack'          => 'Pode Atacar',
        'mode_canmove'            => 'Pode se Mover',
        'mode_castsensorchase'    => 'Persegue ao Detectar Magia',
        'mode_castsensoridle'     => 'Ataca ao Detectar Magia',
        'mode_changechase'        => 'Troca de Alvo ao Perseguir',
        'mode_changetargetchase'  => 'Muda de Alvo Durante a Perseguição',
        'mode_changetargetmelee'  => 'Muda de Alvo Durante Corpo a Corpo',
        'mode_detector'           => 'Detector de Esconderijo',
        'mode_fixeditemdrop'      => 'Drop Fixo de Itens',
        'mode_ignoremagic'        => 'Ignora Magia',
        'mode_ignoremelee'        => 'Ignora Ataques Corpo a Corpo',
        'mode_ignoremisc'         => 'Ignora Dano Diverso',
        'mode_ignoreranged'       => 'Ignora Ataques à Distância',
        'mode_knockbackimmune'    => 'Imune a Knockback',
        'mode_looter'             => 'Saqueador',
        'mode_mvp'                => 'MVP',
        'mode_norandomwalk'       => 'Fixo no Lugar (Planta)',
        'mode_randomtarget'       => 'Alvo Aleatório',
        'mode_skillimmune'        => 'Imune a Habilidades',
        'mode_statusimmune'       => 'Imune a Status Negativos',
        'mode_targetweak'         => 'Prioriza Alvos Fracos',
        'mode_teleportblock'      => 'Bloqueia Teleporte',
    ];

    public function getSize()
    {
        return self::$sizes[$this->size] ?? null;
    }

    public function getRace()
    {
        return self::$races[$this->race] ?? null;
    }

    public function getElement()
    {
        return self::$elements[$this->element] ?? null;
    }

    public function getModes(): array
    {
        return array_values(array_filter($this->modes, function ($key) {
            return $this->$key === 1;
        }, ARRAY_FILTER_USE_KEY));
    }

    public function drop1(): HasOne
    {
        return $this->hasOne(ItemDatabase::class, 'name_aegis', 'drop1_item');
    }

    public function drop2(): HasOne
    {
        return $this->hasOne(ItemDatabase::class, 'name_aegis', 'drop2_item');
    }

    public function drop3(): HasOne
    {
        return $this->hasOne(ItemDatabase::class, 'name_aegis', 'drop3_item');
    }

    public function drop4(): HasOne
    {
        return $this->hasOne(ItemDatabase::class, 'name_aegis', 'drop4_item');
    }

    public function drop5(): HasOne
    {
        return $this->hasOne(ItemDatabase::class, 'name_aegis', 'drop5_item');
    }

    public function drop6(): HasOne
    {
        return $this->hasOne(ItemDatabase::class, 'name_aegis', 'drop6_item');
    }

    public function drop7(): HasOne
    {
        return $this->hasOne(ItemDatabase::class, 'name_aegis', 'drop7_item');
    }

    public function drop8(): HasOne
    {
        return $this->hasOne(ItemDatabase::class, 'name_aegis', 'drop8_item');
    }

    public function drop9(): HasOne
    {
        return $this->hasOne(ItemDatabase::class, 'name_aegis', 'drop9_item');
    }

    public function drop10(): HasOne
    {
        return $this->hasOne(ItemDatabase::class, 'name_aegis', 'drop10_item');
    }

    public function mvpDrop1(): HasOne
    {
        return $this->hasOne(ItemDatabase::class, 'name_aegis', 'mvpdrop1_item');
    }

    public function mvpDrop2(): HasOne
    {
        return $this->hasOne(ItemDatabase::class, 'name_aegis', 'mvpdrop2_item');
    }

    public function mvpDrop3(): HasOne
    {
        return $this->hasOne(ItemDatabase::class, 'name_aegis', 'mvpdrop3_item');
    }
}
