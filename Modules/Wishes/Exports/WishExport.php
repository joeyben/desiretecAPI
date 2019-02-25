<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 17.12.18
 * Time: 12:28.
 */

namespace Modules\Wishes\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Wishes\Repositories\Contracts\WishesRepository;
use PhpOffice\PhpSpreadsheet\Shared\Date;

/**
 * Class WishExport.
 */
class WishExport implements FromCollection, Responsable, WithMapping, WithHeadings, WithColumnFormatting, ShouldAutoSize
{
    use Exportable;
    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    private $fileName = 'wishes.xlsx';
    /**
     * @var \Modules\Wishes\Repositories\Contracts\WishesRepository
     */
    private $wishes;

    /**
     * WishExport constructor.
     *
     * @param \Modules\Wishes\Repositories\Contracts\WishesRepository $wishes
     */
    public function __construct(WishesRepository $wishes)
    {
        $this->wishes = $wishes;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->wishes->all();
    }

    /**
     * @param mixed $wish
     *
     * @return array
     */
    public function map($wish): array
    {
        return [
            $wish->id,
            $wish->title,
            $wish->airport,
            $wish->destination,
            '€ ' . $wish->budget,
            $wish->earliest_start,
            $wish->latest_return,
            $wish->adults,
            $wish->kids,
            $wish->status ? 'Active' : 'Inactive',
            $wish->booking_status,
            null === $wish->owner ? '' : $wish->owner->full_name,
            $wish->whitelabel->display_name,
            $wish->group->display_name,
            $wish->description,
            Date::dateTimeToExcel($wish->updated_at),
            Date::dateTimeToExcel($wish->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            Lang::get('tables.title'),
            Lang::get('tables.airport'),
            Lang::get('tables.destination'),
            Lang::get('tables.budget'),
            Lang::get('tables.earliest_start'),
            Lang::get('tables.latest_return'),
            Lang::get('tables.adults'),
            Lang::get('tables.kids'),
            Lang::get('tables.status'),
            Lang::get('tables.booking_status'),
            Lang::get('tables.owner'),
            Lang::get('tables.whitelabel'),
            Lang::get('tables.group'),
            Lang::get('tables.description'),
            Lang::get('tables.updated_at'),
            Lang::get('tables.created_at'),
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'O' => 'dd.mm.yy',
            'P' => 'dd.mm.yy',
        ];
    }
}
