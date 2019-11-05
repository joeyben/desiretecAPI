<?php

namespace Modules\Whitelabels\Repositories\Contracts;

interface WhitelabelsRepository
{
    public function generateFiles(int $id, string $name);

    public function generateFile(string $source, string $destination, array $placeholders = [], array $values = []);

    public function copyLanguage(string $table, string $locale);

    public function current();
}
