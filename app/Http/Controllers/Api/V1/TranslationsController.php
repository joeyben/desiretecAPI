<?php


namespace App\Http\Controllers\Api\V1;


use Illuminate\Http\Request;
use Modules\LanguageLines\Entities\Translation;

class TranslationsController extends APIController
{
    public function __construct()
    {
    }

    public function getTranslations(Request $request)
    {
        $group = $request->get('group');
        $locale = $request->get('locale', 'de');
        $whitelabelId = $request->get('whitelabel_id', null);


        return $this->loadTranslations($locale, $group, $whitelabelId);
    }

    public function loadTranslations(string $locale, string $group, int $whitelabelId = null): array
    {
        return Translation::getTranslationsForGroup($locale, $group, $whitelabelId);
    }
}
