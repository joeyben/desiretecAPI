<?php

namespace Modules\Whitelabels\Repositories\Contracts;

interface WhitelabelsRepository
{
    public function updateRoute(int $id, string $name, string $subDomain);

    public function generateFiles(int $id, string $name);

    public function generateFile(string $source, string $destination, array $placeholders = [], array $values = []);

    public function copyLanguage(string $table, string $locale);

    public function apiCopyLanguage(int $whitelabelId);

    public function current(bool $first = true);

    public function getBackgroundImage($whitelabel);

    public function getLogo($whitelabel);

    public function getFavicon($whitelabel);

    public function getSubDomain(string $domain);

    public function getDomain(string $domain);

    public function getVisual($whitelabel);

    public function getTourOperators(int $whitelabelId);

    public function addHost(string $host);

    public function deleteHost(string $host);

    public function updateHost(int $id, string $host, string $newHost);
}
