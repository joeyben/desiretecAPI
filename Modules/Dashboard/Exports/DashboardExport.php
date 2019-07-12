<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 17.12.18
 * Time: 12:28.
 */

namespace Modules\Dashboard\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Dashboard\Repositories\Contracts\DashboardRepository;
use PhpOffice\PhpSpreadsheet\Shared\Date;

/**
 * Class DashboardExport.
 */
class DashboardExport implements FromCollection, Responsable, WithMapping, WithHeadings, WithColumnFormatting, ShouldAutoSize
{
    use Exportable;
    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    private $fileName = 'dashboard.xlsx';
    /**
     * @var \Modules\Dashboard\Repositories\Contracts\DashboardRepository
     */
    private $dashboard;

    /**
     * WishExport constructor.
     *
     * @param \Modules\Dashboard\Repositories\Contracts\DashboardRepository $dashboard
     */
    public function __construct()
    {
        
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return collect([1,2,3]);
    }

    /**
     * @param mixed $wish
     *
     * @return array
     */
    public function map($wish): array
    {
        return [
            'LI Desktop',
        ];
    }

    public function headings(): array
    {
        return [
            '#',
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
        ];
    }
}
