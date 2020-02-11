<?php

namespace Modules\LanguageLines\Entities;

use Illuminate\Support\Facades\Cache;
use Modules\LanguageLines\Traits\LanguageLinesSearchableTrait;
use Modules\Whitelabels\Entities\Whitelabel;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\TranslationLoader\LanguageLine;

class LanguageLines extends LanguageLine
{
    use LanguageLinesSearchableTrait;
    use LogsActivity;

    protected static $logOnlyDirty = true;

    protected static $logAttributes = [
        'group',
        'key',
        'text',
        'whitelabel_id',
        'default',
        'licence',
        'is_updated',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $casts = [
        'default'    => 'boolean',
        'is_updated' => 'boolean',
        'licence'    => 'integer',
    ];

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
            'id'                         => 10,
            'locale'                     => 10,
            'group'                      => 10,
            'key'                        => 10,
            'text'                       => 10
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
                        'key'  => $languageLine->key,
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
     * Override to get model from helpers.
     *
     * @return string
     */
    public function getTable()
    {
        return getLanguageLinesTable();
    }

    /**
     * Wishes belongsTo with Whitelabel.
     */
    public function whitelabel()
    {
        return $this->belongsTo(Whitelabel::class);
    }
}
