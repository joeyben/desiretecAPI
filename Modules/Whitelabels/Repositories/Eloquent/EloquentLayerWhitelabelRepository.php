<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Whitelabels\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Modules\Whitelabels\Entities\Layer;
use Modules\Whitelabels\Entities\LayerWhitelabel;
use Modules\Whitelabels\Repositories\Contracts\LayerWhitelabelRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentLayerWhitelabelRepository extends RepositoryAbstract implements LayerWhitelabelRepository
{
    public function model()
    {
        return LayerWhitelabel::class;
    }
}
