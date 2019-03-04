<?php

namespace Modules\Languages\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Modules\Languages\Entities\Language;
use Modules\Languages\Repositories\Contracts\LanguagesRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentLanguagesRepository extends RepositoryAbstract implements LanguagesRepository
{
    public function model()
    {
        return Language::class;
    }
}
