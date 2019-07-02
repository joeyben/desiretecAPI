<?php


namespace Modules\LanguageLines\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
            $exist = DB::table('language_lines')
                ->where('locale', $row['lokal'])
                ->where('group', $row['gruppe'])
                ->where('description', $row['beschreibung'])
                ->where('key', $row['key'])
                ->where('text', $row['text'])
                ->exists();

            if (!$exist) {
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
}
