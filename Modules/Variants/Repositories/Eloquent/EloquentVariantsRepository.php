<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Variants\Repositories\Eloquent;

use App\Repositories\Criteria\ByWhitelabel;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereBetween;
use App\Repositories\Criteria\WithTrashed;
use App\Repositories\RepositoryAbstract;
use Illuminate\Support\Facades\DB;
use Modules\Variants\Repositories\Contracts\VariantsRepository;
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

    public function getVariants(array $parseRequest)
    {
        [$perPage, $sort, $search] = $parseRequest;

        return $this->withCriteria([
            new WithTrashed(),
            new OrderBy($sort[0], $sort[1]),
            new ByWhitelabel('variants'),
            new EagerLoad(['whitelabel', 'layerWhitelabel'  => function ($query) {
                $query->select('id', 'whitelabel_id', 'layer_id')->with('layer');
            }]),
        ])->paginate($perPage);
    }
}
