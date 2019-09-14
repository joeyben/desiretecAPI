<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Autooffers\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Modules\Autooffers\Entities\AutooffersSetting;
use Modules\Autooffers\Repositories\Contracts\AutooffersRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentAutooffersRepository extends RepositoryAbstract implements AutooffersRepository
{
    public function model()
    {
        return AutooffersSetting::class;
    }

    public function updateStatus($rule, array $status, int $whitelabelId)
    {
        AutooffersSetting::where('status', true)->where('whitelabel_id', $whitelabelId)
            ->update(['status' => false]);

        $rule->update($status);

        return $rule;
    }
}
