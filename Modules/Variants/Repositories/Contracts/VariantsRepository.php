<?php

namespace Modules\Variants\Repositories\Contracts;

interface VariantsRepository
{
    public function getVariants(array $parseRequest);

    public function getWhitelabel($request);
}