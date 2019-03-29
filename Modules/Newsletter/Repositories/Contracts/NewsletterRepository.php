<?php

namespace Modules\Newsletter\Repositories\Contracts;

interface NewsletterRepository
{
    public function subscribe(string $email);
}
