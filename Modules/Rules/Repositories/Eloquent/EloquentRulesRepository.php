<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Rules\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Modules\Rules\Entities\Rule;
use Modules\Rules\Repositories\Contracts\RulesRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentRulesRepository extends RepositoryAbstract implements RulesRepository
{
    public function model()
    {
        return Rule::class;
    }

    public function updateStatus($rule, array $status, int $whitelabelId)
    {
        Rule::where('status', true)->where('whitelabel_id', $whitelabelId)
            ->update(['status' => false]);

        $rule->update($status);

        return $rule;
    }
}
