<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSetting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'stats' => 'array',
    ];

    /**
     * Hero is conceptually a singleton — there's only one hero block on the site.
     * This helper returns the single record, creating defaults if missing.
     */
    public static function current(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'title_top' => 'ВКЛЮЧАЕМ',
                'title_middle' => 'БЛОГЕРОВ',
                'title_bottom_prefix' => 'В ВАШИ',
                'title_accent' => 'ПРОДАЖИ',
                'description' => 'Influence-агентство Юрия Дехтяра. Подбираем авторов, продумываем механику и доводим до измеримого результата — не просто охватов.',
                'stats' => [
                    ['num' => '200+',  'label' => 'кампаний / реализовано'],
                    ['num' => '50М+',  'label' => 'охватов / суммарно'],
                    ['num' => '90%',   'label' => 'клиентов / возвращаются'],
                    ['num' => 'с 2020','label' => 'года / на рынке'],
                ],
            ]
        );
    }
}
