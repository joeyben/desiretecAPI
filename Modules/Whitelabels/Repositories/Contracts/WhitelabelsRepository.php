<?php

namespace Modules\Whitelabels\Repositories\Contracts;

use Modules\Whitelabels\Entities\Whitelabel;

interface WhitelabelsRepository
{
    public function updateRoute(int $id, string $name, string $subDomain);

    public function generateFiles(int $id, string $name);

    public function generateFile(string $source, string $destination, array $placeholders = [], array $values = []);

    public function copyLanguage(string $table, string $locale);

    public function current();

    public function getBackgroundImage($whitelabel);

    public function getLogo($whitelabel);

    public function getFavicon($whitelabel);

    public function getSubDomain(string $domain);

    public function getDomain(string $domain);
}
