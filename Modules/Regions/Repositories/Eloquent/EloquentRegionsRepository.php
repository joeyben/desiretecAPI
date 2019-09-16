<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Regions\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Modules\Regions\Entities\Region;
use Modules\Regions\Repositories\Contracts\RegionsRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentRegionsRepository extends RepositoryAbstract implements RegionsRepository
{
    public function model()
    {
        return Region::class;
    }
}
