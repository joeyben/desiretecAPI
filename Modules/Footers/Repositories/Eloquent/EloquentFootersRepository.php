<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Footers\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Modules\Footers\Entities\Footer;
use Modules\Footers\Repositories\Contracts\FootersRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentFootersRepository extends RepositoryAbstract implements FootersRepository
{
    public function model()
    {
        return Footer::class;
    }
}
