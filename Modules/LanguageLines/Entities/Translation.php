<?php

namespace Modules\LanguageLines\Entities;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Spatie\TranslationLoader\LanguageLine;

class Translation extends Model
{
    /** @var array */
    public $table = 'language_lines';

    /** @var array */
    public $translatable = [];

    /** @var array */
    public $guarded = ['id'];

    /** @var array */
    protected $casts = [];

    public static function boot()
    {
        parent::boot();

        $flushGroupCache = function (self $languageLine) {
            $languageLine->flushGroupCache();
        };

        static::saved($flushGroupCache);
        static::deleted($flushGroupCache);
    }

    public static function getTranslationsForGroup(string $locale, string $group, int $whitelabelId = null): array
    {
        return Cache::rememberForever(static::getCacheKey($group, $locale, $whitelabelId), function () use ($group, $locale, $whitelabelId) {
            return static::query()
                ->where('whitelabel_id', $whitelabelId)
                ->where('group', $group)
                ->where('locale', $locale)
                ->get()
                ->map(function (Translation $translation) {
                    return [
                        'key' => $translation->key,
                        'text' => $translation->text,
                    ];
                })
                ->pluck('text', 'key')
                ->toArray();
        });
    }

    public static function getCacheKey(string $group, string $locale, int $whitelabelId = null): string
    {
        return "spatie.translation-loader.{$whitelabelId}.{$group}.{$locale}";
    }

    protected function flushGroupCache()
    {
        Cache::forget(static::getCacheKey($this->group, $this->locale, $this->whitelabel_id));
    }
}
