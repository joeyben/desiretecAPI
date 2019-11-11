<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Agents\Repositories\Eloquent;

use App\Models\Agents\Agent;
use App\Repositories\RepositoryAbstract;
use Modules\Agents\Repositories\Contracts\AgentsRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentAgentsRepository extends RepositoryAbstract implements AgentsRepository
{
    public function model()
    {
        return Agent::class;
    }
}
