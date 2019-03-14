<?php

namespace Modules\Languages\Repositories\Contracts;

interface LanguagesRepository
{
    public function findLanguages();

    public function findMissingLanguages();

    public function copyLanguage(string $locale);
}
