<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Wishes\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Modules\Wishes\Entities\Wish;
use Modules\Wishes\Repositories\Contracts\WishesRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentWishesRepository extends RepositoryAbstract implements WishesRepository
{
    public function model()
    {
        return Wish::class;
    }
}
