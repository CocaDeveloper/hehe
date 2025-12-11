<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Char extends Model
{
    protected $table = 'char';

    public $timestamps = false;

    protected $primaryKey = 'char_id';

    public function guild(): BelongsTo
    {
        return $this->belongsTo(Guild::class, 'guild_id', 'guild_id');
    }

    private static array $classes = [
        0    => 'Noviço',
        1    => 'Espadachim',
        2    => 'Mago',
        3    => 'Arqueiro',
        4    => 'Acolito',
        5    => 'Mercador',
        6    => 'Gatuno',
        7    => 'Cavaleiro',
        8    => 'Sacerdote',
        9    => 'Bruxo',
        10   => 'Ferreiro',
        11   => 'Caçador',
        12   => 'Algoz',
        14   => 'Templário',
        15   => 'Monge',
        16   => 'Sábio',
        17   => 'Arruaceiro',
        18   => 'Alquimista',
        19   => 'Bardo',
        20   => 'Odalisca',
        22   => 'Casamento',
        23   => 'Super Aprendiz',
        24   => 'Justiceiro',
        25   => 'Ninja',
        26   => 'Natal',
        27   => 'Verão',
        28   => 'Hanbok',
        29   => 'Oktoberfest',

        4001 => 'Aprendiz Alt.',
        4002 => 'Espadachim Alt.',
        4003 => 'Mago Alt.',
        4004 => 'Arqueiro Alt.',
        4005 => 'Acolito Alt.',
        4006 => 'Mercador Alt.',
        4007 => 'Gatuno Alt.',
        4008 => 'Lorde Cavaleiro',
        4009 => 'Sumo Sacerdote',
        4010 => 'Arquimago',
        4011 => 'Mestre-Ferreiro',
        4012 => 'Atirador de Elite',
        4013 => 'Algoz',
        4015 => 'Paladino',
        4016 => 'Campeão',
        4017 => 'Professor',
        4018 => 'Desordeiro',
        4019 => 'Criador',
        4020 => 'Menestrel',
        4021 => 'Cigana',

        4023 => 'Bebê',
        4024 => 'Espadachim Bebê',
        4025 => 'Mago Bebê',
        4026 => 'Arqueiro Bebê',
        4027 => 'Acolito Bebê',
        4028 => 'Mercador Bebê',
        4029 => 'Gatuno Bebê',
        4030 => 'Cavaleiro Bebê',
        4031 => 'Sacerdote Bebê',
        4032 => 'Bruxo Bebê',
        4033 => 'Ferreiro Bebê',
        4034 => 'Caçador Bebê',
        4035 => 'Algoz Bebê',
        4037 => 'Templário Bebê',
        4038 => 'Monge Bebê',
        4039 => 'Sábio Bebê',
        4040 => 'Arruaceiro Bebê',
        4041 => 'Alquimista Bebê',
        4042 => 'Bardo Bebê',
        4043 => 'Odalisca Bebê',
        4045 => 'Super Bebê',

        4046 => 'Taekwon',
        4047 => 'Espiritualista',
        4049 => 'Linker Espiritual',

        4050 => 'Jiang Shi',
        4051 => 'Cavaleiro da Morte',
        4052 => 'Coletor Sombrio',

        4054 => 'Cavaleiro Rúnico',
        4055 => 'Feiticeiro',
        4056 => 'Sentinela',
        4057 => 'Arcebispo',
        4058 => 'Mecânico',
        4059 => 'Sicário',
        4060 => 'Cavaleiro Rúnico+',
        4061 => 'Feiticeiro+',
        4062 => 'Sentinela+',
        4063 => 'Arcebispo+',
        4064 => 'Mecânico+',
        4065 => 'Sicário+',
        4066 => 'Guarda Real',
        4067 => 'Feiticeiro Arcano',
        4068 => 'Trovador',
        4069 => 'Musas',
        4070 => 'Shura',
        4071 => 'Bioquímico',
        4072 => 'Renegado',
        4073 => 'Guarda Real+',
        4074 => 'Feiticeiro Arcano+',
        4075 => 'Trovador+',
        4076 => 'Musas+',
        4077 => 'Shura+',
        4078 => 'Bioquímico+',
        4079 => 'Renegado+',

        4096 => 'Bebê Cavaleiro Rúnico',
        4097 => 'Bebê Feiticeiro',
        4098 => 'Bebê Sentinela',
        4099 => 'Bebê Arcebispo',
        4100 => 'Bebê Mecânico',
        4101 => 'Bebê Sicário',
        4102 => 'Bebê Guarda Real',
        4103 => 'Bebê Feiticeiro Arcano',
        4104 => 'Bebê Trovador',
        4105 => 'Bebê Musa',
        4106 => 'Bebê Shura',
        4107 => 'Bebê Bioquímico',
        4108 => 'Bebê Renegado',

        4190 => 'Super Aprendiz Expandido',
        4191 => 'Super Bebê Expandido',

        4211 => 'Kagerou',
        4212 => 'Oboro',

        4215 => 'Rebelde',
        4218 => 'Invocador',

        4220 => 'Bebê Invocador',
        4222 => 'Bebê Ninja',
        4223 => 'Bebê Kagerou',
        4224 => 'Bebê Oboro',
        4225 => 'Bebê Taekwon',
        4226 => 'Bebê Espiritualista',
        4227 => 'Bebê Linker Espiritual',
        4228 => 'Bebê Justiceiro',
        4229 => 'Bebê Rebelde',

        4239 => 'Imperador Estelar',
        4240 => 'Ceifador de Almas',
        4241 => 'Bebê Imperador Estelar',
        4242 => 'Bebê Ceifador de Almas',

        4252 => 'Cavaleiro Dragão',
        4253 => 'Mestre Ferreiro',
        4254 => 'Cruz Sombria',
        4255 => 'Mago Arcano',
        4256 => 'Cardeal',
        4257 => 'Falcão do Vento',
        4258 => 'Guarda Imperial',
        4259 => 'Biolo',
        4260 => 'Perseguidor Abissal',
        4261 => 'Mestre Elemental',
        4262 => 'Inquisidor',
        4263 => 'Trovador Arcano',
        4264 => 'Trouvère',
    ];

    public function getClass()
    {
        return self::$classes[$this->class] ?? null;
    }
}
