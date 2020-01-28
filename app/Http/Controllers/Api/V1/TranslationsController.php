<?php


namespace App\Http\Controllers\Api\V1;


use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Translation\Translator;
use Spatie\TranslationLoader\Exceptions\InvalidConfiguration;
use Spatie\TranslationLoader\LanguageLine;

class TranslationsController extends APIController
{
    public function __construct()
    {
    }

    public function getTranslations(Request $request)
    {
        $group = $request->get('group');
        $locale = $request->get('locale');



        return $this->loadTranslations($locale, $group);
    }

    public function loadTranslations(string $locale, string $group): array
    {
        $model = $this->getConfiguredModelClass();

        return $model::getTranslationsForGroup($locale, $group);
    }

    protected function getConfiguredModelClass(): string
    {
        $modelClass = config('translation-loader.model');

        if (! is_a(new $modelClass, LanguageLine::class)) {
            throw InvalidConfiguration::invalidModel($modelClass);
        }

        return $modelClass;
    }

}
