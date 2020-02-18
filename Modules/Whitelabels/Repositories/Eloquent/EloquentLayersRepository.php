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
use Modules\Whitelabels\Repositories\Contracts\LayersRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentLayersRepository extends RepositoryAbstract implements LayersRepository
{
    public function model()
    {
        return Layer::class;
    }
}
