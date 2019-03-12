<?php

namespace Modules\Languages\Repositories\Contracts;

interface LanguagesRepository
{
    public function findByWhitelabelId(int $whitelabelId);
}
