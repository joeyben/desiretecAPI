<?php

namespace Modules\Groups\Services;

use App\Repositories\Criteria\ByWhitelabel;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereBetween;
use App\Repositories\Criteria\WithTrashed;
use App\Services\ServiceAbstract;
use Illuminate\Auth\AuthManager;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Modules\Groups\Repositories\Contracts\GroupsRepository;
use Modules\Groups\Services\Contracts\GroupsServiceInterface;

/**
 * Class GroupsService.
 */
class GroupsService extends ServiceAbstract implements GroupsServiceInterface
{
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @return mixed
     */
    protected function repository()
    {
        return GroupsRepository::class;
    }

    public function paginate($request): LengthAwarePaginator
    {
        [$perPage, $sort, $search] = $this->parseRequest($request);

        return $this->resolveRepository()->withCriteria([
            new WithTrashed(),
            new OrderBy($sort[0], $sort[1]),
            new Where('groups.whitelabel_id', $request->get('whitelabel')),
            new WhereBetween('groups.created_at', $request->get('start'), $request->get('end')),
            new Filter($search),
            new EagerLoad(['owner' => function ($query) {
                $select = $this->auth->guard('web')->user()->hasRole('Administrator') ? 'CONCAT(first_name, " ", last_name, " ( ", email, " ) ") AS full_name' : 'CONCAT(first_name, " ", last_name) AS full_name';
                $query->select('users.id', DB::raw($select));
            }, 'users'  => function ($query) {
                $query->select('users.id', DB::raw('CONCAT(first_name, " ", last_name, " ( ", email, " ) ") AS full_name'));
            }, 'whitelabel'  => function ($query) {
                $query->select('id', 'display_name');
            }]),
            new ByWhitelabel('groups')
        ])->paginate($perPage);
    }
}
