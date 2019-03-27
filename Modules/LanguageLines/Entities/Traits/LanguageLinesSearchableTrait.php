<?php

namespace Modules\LanguageLines\Traits;

use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

trait LanguageLinesSearchableTrait
{
    use SearchableTrait;

    public function getColumns()
    {
        $table = getLanguageLinesTable();
        if (array_key_exists('columns', $this->searchable)) {
            $driver = $this->getDatabaseDriver();
            $prefix = Config::get("database.connections.$driver.prefix");
            $columns = [];
            foreach($this->searchable['columns'] as $column => $priority){
                $columns[$prefix . $table . '.' . $column] = $priority;
            }

            return $columns;
        } else {
            return DB::connection()->getSchemaBuilder()->getColumnListing($this->table);
        }
    }
}