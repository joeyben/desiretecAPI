<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 17.12.18
 * Time: 12:28.
 */

namespace Modules\Groups\Exports;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Groups\Repositories\Contracts\GroupsRepository;
use PhpOffice\PhpSpreadsheet\Shared\Date;

/**
 * Class GroupExport.
 */
class GroupExport implements FromCollection, Responsable, WithMapping, WithHeadings, WithColumnFormatting, ShouldAutoSize
{
    use Exportable;
    /**
     * It's required to define the fileName within
     * the export class when making use of Responsable.
     */
    private $fileName = 'groups.xlsx';
    /**
     * @var \Modules\Groups\Repositories\Contracts\GroupsRepository
     */
    private $groups;

    /**
     * GroupExport constructor.
     *
     * @param \Modules\Groups\Repositories\Contracts\GroupsRepository $groups
     */
    public function __construct(GroupsRepository $groups)
    {
        $this->groups = $groups;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return $this->groups->all();
    }

    /**
     * @param mixed $group
     *
     * @return array
     */
    public function map($group): array
    {
        return [
            $group->id,
            $group->status ? 'Active' : 'Inactive',
            $group->name,
            null === $group->owner ? '' : $group->owner->full_name,
            $group->whitelabel->display_name,
            implode(', ', $group->users->pluck('full_name')->all()),
            Date::dateTimeToExcel($group->updated_at),
            Date::dateTimeToExcel($group->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            Lang::get('tables.status'),
            Lang::get('tables.name'),
            Lang::get('tables.owner'),
            Lang::get('tables.whitelabel'),
            Lang::get('tables.users'),
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
            'G' => 'dd.mm.yy',
            'H' => 'dd.mm.yy',
        ];
    }
}
