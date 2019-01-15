<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Whitelabels\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Modules\Whitelabels\Entities\Whitelabel;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentWhitelabelsRepository extends RepositoryAbstract implements WhitelabelsRepository
{
    public function model()
    {
        return Whitelabel::class;
    }
}
