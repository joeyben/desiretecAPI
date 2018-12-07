<?php

namespace Modules\Activities\Repositories\Contracts;

interface ActivitiesRepository
{
    /**
     * @param $subject
     *
     * @return array
     */
    public function byModel($subject): array;
}
