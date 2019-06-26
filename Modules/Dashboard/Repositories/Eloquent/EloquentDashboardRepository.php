<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Dashboard\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use Modules\Dashboard\Entities\Dashboard;
use Modules\Dashboard\Repositories\Contracts\DashboardRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentDashboardRepository.
 */
class EloquentDashboardRepository extends RepositoryAbstract implements DashboardRepository
{
    public function model()
    {
        return Dashboard::class;
    }

    public function uniqueEventsDay(string $gaViewId, array $optParams, string $startDate, string $endDate)
    {
        return \Analytics::getAnalyticsService()->data_ga->get(
            'ga:'.$gaViewId,
            ($startDate === '') ? '30daysAgo' : $startDate ,
            ($endDate === '') ?'yesterday' : $endDate,
            'ga:uniqueEvents',
            $optParams
        )->rows;
    }

    public function uniqueEventsMonth(string $gaViewId, array $optParams, string $startDate, string $endDate)
    {
        return \Analytics::getAnalyticsService()->data_ga->get(
            'ga:'.$gaViewId,
            ($startDate === '') ? '365daysAgo' : $startDate,
            ($endDate === '') ? 'yesterday' : $endDate,
            'ga:uniqueEvents',
            $optParams
        )->rows;
    }

    public function calculateBrowserData(array $result, array $browsers, int $sum)
    {
        foreach ($result['ga'] as $key => $value) {
            if (!in_array($result['ga'][$key][0], $browsers)) {
              unset($result['ga'][$key]);
          }  
      }
      $result['ga'] = array_values($result['ga']);
      foreach ($result['ga'] as $key => $value) {
        $sum = $sum +  $result['ga'][$key][1];  
    }
    foreach ($result['ga'] as $key => $value) {
        $result['ga'][$key][1] = round($result['ga'][$key][1]/$sum*100,1);
    }

    return $result['ga'];
    }

    public function calculateResponseData( $result, $data, $stack)
    {
        $i = 0;
        $j = 0;
        foreach ($data as $k => $v) {
            list($year, $month, $day) = explode("-", $k); 
            $stack[$k]['date'] = $year.$month;
            $stack[$k]['wish'] = $v;
        }

        $result['wishes'] = $stack;
        $result['data'] = $data;

        foreach ($result['ga'] as $key => $value) {
            foreach ($result['wishes'] as $kk => $vv) {
               if ($result['ga'][$key][0] === $result['wishes'][$kk]['date']) {
                $i++;
                $j = 0;
                $result['ga'][$key][1] = $result['ga'][$key][1]==='0' ? 0 : round(($result['wishes'][$kk]['wish']/$result['ga'][$key][1])*100,1);
                break;
            }else{
                $j++;
            }
        }
        if ($j!=0) {
           $result['ga'][$key][1] = 0;
       }
   } 
   return $result['ga'];
    }

    public function loadClickRate()
    {
        $sent_emails = DB::table('sent_emails')
        ->select((DB::raw('DATE_FORMAT(sent_emails.created_at,"%Y%m%d") as date')),DB::raw('count(*) as nb_emails'))
        ->groupBy('created_at')
        ->get()->toArray();
        $click_links = DB::table('sent_emails_url_clicked')
        ->join('sent_emails','sent_email_id','=','sent_emails.id')
        ->select((DB::raw('DATE_FORMAT(sent_emails.created_at,"%Y%m%d") as date')),DB::raw('sum(sent_emails_url_clicked.clicks) as clicks'))
        ->groupBy('sent_emails.created_at')
        ->get()->toArray();

        if (!empty($sent_emails)) {
            foreach ($sent_emails as $key => $value) {
                $result['sent'][$key][0] = $sent_emails[$key]->date;
                unset($sent_emails[$key]->date);
                $result['sent'][$key][1] = $sent_emails[$key]->nb_emails;
                unset($sent_emails[$key]->nb_emails);
            }
            if (!empty($click_links)) {
                foreach ($click_links as $key => $value) {
                    $result['click'][$key][0] = $click_links[$key]->date;
                    unset($click_links[$key]->date);
                    $result['click'][$key][1] = $click_links[$key]->clicks;
                    unset($click_links[$key]->clicks);    
                }
            }
            $result['clickrate'] = $result['sent'];
            foreach ($result['clickrate'] as $key => $value) {
                $result['clickrate'][$key][0] = $result['sent'][$key][0];
                if (!empty($click_links) && array_key_exists($key, $result['click'])) {
                    $result['clickrate'][$key][1] = round($result['click'][$key][1]/$result['sent'][$key][1]*100,1);
                }else{
                    $result['clickrate'][$key][1] = 0;
                }

            }
        }else{
            $result['clickrate'] = [0,0];
        }
        return $result['clickrate'];
    }
}
