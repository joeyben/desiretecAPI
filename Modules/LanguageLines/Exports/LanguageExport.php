<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 17.12.18
 * Time: 12:28.
 */

namespace Modules\Languages\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\LanguageLines\Repositories\Eloquent\EloquentLanguageLinesRepository;

/**
 * Class LanguageExport.
 */
class LanguageExport implements FromCollection, Responsable, WithMapping, WithHeadings, WithColumnFormatting, ShouldAutoSize
{
    use Exportable;
    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    private $fileName = 'language.xlsx';
    /**
     * @var \Modules\Languages\Repositories\Contracts\LanguagesRepository
     */
    private $language;

    /**
     * LanguageExport constructor.
     */
    public function __construct(EloquentLanguageLinesRepository $language)
    {
        $this->language = $language;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->language->all();
    }

    /**
     * @param mixed $language
     */
    public function map($language): array
    {
        return [
            $language->id,
            $language->locale,
            $language->group,
            $language->description,
            $language->key,
            $language->text
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            Lang::get('tables.locale'),
            Lang::get('tables.group'),
            Lang::get('tables.description'),
            Lang::get('tables.key'),
            Lang::get('tables.text')
        ];
    }

    public function columnFormats(): array
    {
        return [
        ];
    }
}
