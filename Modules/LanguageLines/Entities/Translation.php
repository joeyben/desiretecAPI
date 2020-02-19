<?php

namespace Modules\LanguageLines\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

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

    public static function getTranslations(string $locale, string $group, int $whitelabelId = null)
    {
        return static::query()
            ->where('whitelabel_id', $whitelabelId)
            ->where('group', $group)
            ->where('locale', $locale);
    }

    public static function getTranslationsForGroup(string $locale, string $group, int $whitelabelId = null): array
    {
        return Cache::rememberForever(static::getCacheKey($group, $locale, $whitelabelId), function () use ($group, $locale, $whitelabelId) {
            $data = static::query()
                ->where('whitelabel_id', $whitelabelId)
                ->where('group', $group)
                ->where('locale', $locale)
                ->get()
                ->map(function (self $translation) {
                    return [
                        'key' => $translation->key,
                        'text' => $translation->text,
                    ];
                })
                ->pluck('text', 'key')
                ->toArray();

            if ($data === []) {
                $data = static::query()
                    ->where('group', $group)
                    ->where('locale', $locale)
                    ->get()
                    ->map(function (self $translation) {
                        return [
                            'key' => $translation->key,
                            'text' => $translation->text,
                        ];
                    })
                    ->pluck('text', 'key')
                    ->toArray();
            }

            return $data;
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
