<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Newsletter\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Modules\Newsletter\Entities\Newsletter;
use Modules\Newsletter\Repositories\Contracts\NewsletterRepository;
use Spatie\Newsletter\NewsletterFacade as NewsletterFacade;

/**
 * Class EloquentNewsletterRepository.
 */
class EloquentNewsletterRepository extends RepositoryAbstract implements NewsletterRepository
{
    public function model()
    {
        return Newsletter::class;
    }

    public function subscribe(string $email)
    {
        return NewsletterFacade::subscribe($email);
    }
}
