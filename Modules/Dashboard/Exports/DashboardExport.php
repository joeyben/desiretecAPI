<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 17.12.18
 * Time: 12:28.
 */

namespace Modules\Dashboard\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Dashboard\Repositories\Contracts\DashboardRepository;
use Modules\Wishes\Repositories\Contracts\WishesRepository;

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
    private $wishes;

    private $dashboard;

    private $carbon;

    /**
     * WishExport constructor.
     *
     * @param \Modules\Dashboard\Repositories\Contracts\DashboardRepository $dashboard
     */
    public function __construct(DashboardRepository $dashboard, WishesRepository $wishes, Carbon $carbon)
    {
        $this->dashboard = $dashboard;
        $this->wishes = $wishes;
        $this->carbon = $carbon;
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        session_start();
        $viewid = $_SESSION['viewid'];
        $whitelabel = $_SESSION['whitelabel'];
        $start = $_SESSION['start'];
        $end = $_SESSION['end'];
        $filter = $this->getFilter();
        $optParams = [
            'dimensions' => 'ga:date',
            'filters'    => $filter['filterd'],
        ];
        $optParams1 = [
            'dimensions' => 'ga:date',
            'filters'    => $filter['filterm'],
        ];
        $result = $this->dashboard->uniqueEventsDay($viewid, $optParams, $start, $end);
        $wishes = $this->getWishes($whitelabel, $start, $end);
        $uem = $this->dashboard->uniqueEventsDay($viewid, $optParams1, $start, $end);
        $i = 0;
        $j = 0;
        foreach ($result as $key => $value) {
            $result[$key]['2'] = $uem[$key]['1'];
            if (!$wishes) {
                $result[$key]['3'] = '0';
            }

            foreach ($wishes as $k => $v) {
                if ((string) $k === $result[$key]['0']) {
                    ++$i;
                    $j = 0;
                    $result[$key]['3'] = $v;
                    break;
                }
                ++$j;
            }
            if (0 !== $j) {
                $result[$key]['3'] = '0';
            }
        }

        return collect($result);
    }

    /**
     * @param mixed $wish
     *
     * @return array
     */
    public function map($dash): array
    {
        $d31 = '0' !== $dash['1'] ? round($dash['3'] / $dash['1'] * 100, 1) : 0;
        $d32 = '0' !== $dash['2'] ? round($dash['3'] / $dash['2'] * 100, 1) : 0;

        return [
            $dash['0'],
            $dash['1'],
            $dash['2'],
            '',
            $dash['1'] + $dash['2'],
            '',
            $dash['3'],
            '',
            '',
            $dash['3'],
            '',
            $d31 . '%',
            $d32 . '%',
            '',
            ($d31 + $d32) . '%',
            '',
            '',
            '',
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'LI Desktop',
            'LI Mobile',
            'LI Tablet',
            'LI Total',
            '',
            'Wishes Desktop',
            'Wishes Mobile',
            'Wishes Tablet',
            'Wishes Total',
            '',
            'Response Rate Desktop',
            'Response Rate Mobile',
            'Response Rate Tablet',
            'Response Rate Total',
            '',
            'Reaction quota',
            'Auto offer quota',
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

    public function getWishes($whitelabel, $start, $end)
    {
        if ('' === $start) {
            $data = DB::table('wishes')
            ->select((DB::raw('DATE_FORMAT(created_at,"%Y%m%d") as date')), DB::raw('count(*) as wishes_count'))
            ->Where([
            ['whitelabel_id', '=', $whitelabel],
            ])
            ->whereBetween('created_at', [DB::raw('DATE_ADD(NOW(),INTERVAL -30 day)'), DB::raw('NOW()')])
            ->groupBy('date')
            ->get()
            ->pluck('wishes_count', 'date')
            ->toArray();
        } else {
            $data = DB::table('wishes')
            ->select((DB::raw('DATE_FORMAT(created_at,"%Y%m%d") as date')), DB::raw('count(*) as wishes_count'))
            ->Where([
            ['whitelabel_id', '=', $whitelabel],
            ])
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->get()
            ->pluck('wishes_count', 'date')
            ->toArray();
        }

        return $data;
    }

    public function getFilter()
    {
        $filterdesk = 'ga:eventLabel==eil-desktop;ga:eventAction==shown;ga:eventCategory==desiretec_exitwindow';
        $filtermobile = 'ga:eventLabel==eil-mobile;ga:eventAction==shown;ga:eventCategory==desiretec_exitwindow';
        $filterphone = 'ga:eventLabel==eil-phone;ga:eventAction==shown;ga:eventCategory==desiretec_exitwindow';
        $filtertablet = 'ga:eventLabel==eil-tablet;ga:eventAction==shown;ga:eventCategory==desiretec_exitwindow';
        $filtershare = 'ga:eventLabel==eil-n1;ga:eventAction==Submit-Button;ga:eventCategory==desiretec_exitwindow';

        return ['filterd'=>$filterdesk, 'filterm'=>$filtermobile, 'filters'=>$filtershare, 'filterphone'=>$filterphone, 'filtertablet'=>$filtertablet];
    }
}
