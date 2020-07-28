<?php

namespace Modules\LanguageLines\Entities;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
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

    public static function getCacheKey(string $group, string $locale, $whitelabelId = null): string
    {
        $whitelabel = getLanguageLinesCacheKey();

        return "desiretec.translation-loader.{$whitelabel}.{$group}.{$locale}.{$whitelabelId}";
    }

    public static function getTranslationsForGroup(string $locale, string $group): array
    {

        $whitelabelId = session()->get('wl-id', null);

        return Cache::rememberForever(static::getCacheKey($group, $locale, $whitelabelId), function () use ($group, $locale, $whitelabelId) {
            $data = static::query()
                ->where('group', $group)
                ->where('locale', session()->get('wl-locale', $locale))
                ->where('whitelabel_id', $whitelabelId)
                ->get()
                ->map(function (LanguageLine $languageLine) use ($locale) {
                    return [
                        'key'  => $languageLine->key,
                        'text' => $languageLine->text,
                    ];
                })
                ->pluck('text', 'key')
                ->toArray();

            $defaultItems = static::query()
                ->where('group', $group)
                ->where('locale', session()->get('wl-locale', $locale))
                ->whereNull('whitelabel_id')
                ->get()
                ->map(function (LanguageLine $languageLine) use ($locale) {
                    return [
                        'key'  => $languageLine->key,
                        'text' => $languageLine->text,
                    ];
                })
                ->pluck('text', 'key')
                ->toArray();

            foreach ($defaultItems as $key => $value) {
                if(!array_key_exists($key, $data)) {
                    $data[$key] = $value;
                }
            }

            return $data;
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
