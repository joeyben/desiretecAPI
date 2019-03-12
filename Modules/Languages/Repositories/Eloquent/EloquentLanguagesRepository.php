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

    public function findByWhitelabelId(int $whitelabelId)
    {
        return $this->model()::whereHas('whitelabels', function ($q) use ($whitelabelId) {
            $q->where('whitelabels.id', $whitelabelId);
        })->get();
    }
}
