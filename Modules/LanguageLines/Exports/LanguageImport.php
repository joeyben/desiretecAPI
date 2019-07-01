<?php


namespace Modules\LanguageLines\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Modules\LanguageLines\Entities\LanguageLines;

/**
 * Class LanguageImport
 *
 * @package \Modules\LanguageLines\Exports
 */
class LanguageImport implements ToCollection, WithHeadingRow
{
    /**
     * @param \Illuminate\Support\Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            LanguageLines::create([
                'locale' => $row['lokal'],
                'group' => $row['gruppe'],
                'description' => $row['beschreibung'],
                'key' => $row['key'],
                'text' => $row['text'],
            ]);
        }
    }
}
