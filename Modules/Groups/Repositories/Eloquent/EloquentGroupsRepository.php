<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Groups\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Illuminate\Support\Facades\Auth;
use Modules\Groups\Entities\Group;
use Modules\Groups\Repositories\Contracts\GroupsRepository;
use Modules\Whitelabels\Entities\Whitelabel;

/**
 * Class EloquentPostsRepository.
 */
class EloquentGroupsRepository extends RepositoryAbstract implements GroupsRepository
{
    public function model()
    {
        return Group::class;
    }

    public function updateCurrent(Group $group, array $current, int $whitelabelId)
    {
        Group::where('current', true)->where('whitelabel_id', $whitelabelId)
            ->update(['current' => false]);

        $group->update($current);

        return $group;
    }

    public function getWhitelabel($request): Whitelabel
    {
        $whitelabel = Auth::guard('web')->user()->whitelabels()->first();

        if ((null === $whitelabel) && $request->has('whitelabel_id')) {
            $whitelabel = Whitelabel::find($request->get('whitelabel_id'));
        }

        return $whitelabel;
    }
}
