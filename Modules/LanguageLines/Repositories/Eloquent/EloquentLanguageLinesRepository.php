<?php

namespace Modules\LanguageLines\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
//use Modules\LanguageLines\Entities\LanguageLines;
use Modules\LanguageLines\Repositories\Contracts\LanguageLinesRepository;

/**
 * Class EloquentLanguageLinesRepository.
 */
class EloquentLanguageLinesRepository extends RepositoryAbstract implements LanguageLinesRepository
{
    public function model()
    {
        return \Config::get('translation-loader.model');
    }
}
