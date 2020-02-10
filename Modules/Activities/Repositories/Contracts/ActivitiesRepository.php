<?php

namespace Modules\Activities\Repositories\Contracts;

interface ActivitiesRepository
{
    /**
     * @param $subject
     */
    public function byModel($subject): array;
}
