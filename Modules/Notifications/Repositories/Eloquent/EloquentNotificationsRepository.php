<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Notifications\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Modules\Notifications\Entities\Group;
use Modules\Notifications\Entities\Notification;
use Modules\Notifications\Repositories\Contracts\NotificationsRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentNotificationsRepository extends RepositoryAbstract implements NotificationsRepository
{
    public function model()
    {
        return Notification::class;
    }
}
