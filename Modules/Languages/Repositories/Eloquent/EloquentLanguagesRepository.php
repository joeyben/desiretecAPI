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

    public function findLanguages()
    {
        if (isWhiteLabel()) {
            return $this->findByWhitelabelId(getCurrentWhiteLabelId());
        }

        return $this->all();
    }

    private function findByWhitelabelId(int $whitelabelId)
    {
        return $this->model()::whereHas('whitelabels', function ($q) use ($whitelabelId) {
            $q->where('whitelabels.id', $whitelabelId);
        })->get();
    }

    public function findMissingLanguages()
    {
        if (isWhiteLabel()) {
            $whitelabelId = getCurrentWhiteLabelId();

            return $this->model()::whereDoesntHave('whitelabels', function ($q) use ($whitelabelId) {
                $q->where('whitelabels.id', $whitelabelId);
            })->get();
        }

        return [];
    }

    public function copyLanguage(string $locale)
    {
        $languageLines = $this->getWithRelation(['locale' => 'en'], ['locale', 'group', 'key', 'text'])
            ->map(function ($languageLine) use ($locale) {
                return [
                    'locale' => $locale,
                    'group'  => $languageLine->group,
                    'key'    => $languageLine->key,
                    'text'   => $languageLine->text,
                ];
            })
            ->toArray();

        return $this->create($languageLines);
    }
}
