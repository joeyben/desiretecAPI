<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Variants\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Modules\Agents\Repositories\Contracts\VariantsRepository;
use Modules\Variants\Entities\Variant;

/**
 * Class EloquentPostsRepository.
 */
class EloquentVariantsRepository extends RepositoryAbstract implements VariantsRepository
{
    public function model()
    {
        return Variant::class;
    }
}
