<?php

namespace Modules\LanguageLines\Entities;

use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\TranslationLoader\LanguageLine;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;


class LanguageLines extends LanguageLine
{
    use SearchableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $casts = [];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /*
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'language_lines.id'                         => 10,
            'language_lines.locale'                     => 10,
            'language_lines.group'                      => 10,
            'language_lines.key'                        => 10,
            'language_lines.text'                       => 10
        ]
    ];

    public static function boot()
    {
        parent::boot();
        static::updated(function (LanguageLine $languageLine) {
            $languageLine->flushGroupCache();
        });
    }

    public static function getCacheKey(string $group, string $locale): string
    {
        $whitelabel = getLanguageLinesCacheKey();
        return "desiretec.translation-loader.{$whitelabel}.{$group}.{$locale}";
    }

    public static function getTranslationsForGroup(string $locale, string $group): array
    {
        return Cache::rememberForever(static::getCacheKey($group, $locale), function () use ($group, $locale) {
            return static::query()
                ->where('group', $group)
                ->where('locale', $locale)
                ->get()
                ->map(function (LanguageLine $languageLine) use ($locale) {
                    return [
                        'key' => $languageLine->key,
                        'text' => $languageLine->text,
                    ];
                })
                ->pluck('text', 'key')
                ->toArray();
        });
    }

    protected function flushGroupCache()
    {
        Cache::forget(static::getCacheKey($this->group, $this->locale));
    }

    /**
     * Override to get model from helpers
     *
     * @return string
     */
    public function getTable()
    {
        return getLanguageLinesTable();
    }
}
