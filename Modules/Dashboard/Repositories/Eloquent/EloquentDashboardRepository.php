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
use Illuminate\Http\Request;


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
        $i = 0;
        $j = 0;
        $sent_emails = DB::table('sent_emails')
        ->select((DB::raw('DATE_FORMAT(sent_emails.created_at,"%Y%m%d") as date')),DB::raw('count(*) as nb_emails'))
        ->groupBy('date')
        ->get()->toArray();

        $click_links = DB::table('sent_emails_url_clicked')
        ->join('sent_emails','sent_email_id','=','sent_emails.id')
        ->select((DB::raw('DATE_FORMAT(sent_emails.created_at,"%Y%m%d") as date')),DB::raw('sum(sent_emails_url_clicked.clicks) as clicks'))
        ->where('url','like','%/wish/%')
        ->groupBy('date')
        ->get()->toArray();

        if (!empty($sent_emails)) {
            foreach ($sent_emails as $key => $value) {
                $result['sent'][$key][0] = $sent_emails[$key]->date;
                $result['sent'][$key][1] = $sent_emails[$key]->nb_emails;
            }
            if (!empty($click_links)) {
                foreach ($click_links as $key => $value) {
                    $result['click'][$key][0] = $click_links[$key]->date;
                    $result['click'][$key][1] = $click_links[$key]->clicks;
                }
            }
            $result['clickrate'] = $result['sent'];
            foreach ($result['clickrate'] as $key => $value) {
                $result['clickrate'][$key][0] = $result['sent'][$key][0];
                if (!empty($click_links) && $result['clickrate'][$key][1]!=='0') {
                    foreach ($result['click'] as $k => $v) {
                        if ($result['clickrate'][$key][0]===$result['click'][$k][0]) {
                            $i++;
                            $j = 0;
                           $result['clickrate'][$key][1] = round($result['click'][$k][1]/$result['clickrate'][$key][1]*100,1); 
                           break;
                        }else{
                            $j++;
                        }
                        
                    }
                    if ($j!=0) {
                            $result['clickrate'][$key][1] = 0;
                        }
                }else{
                    $result['clickrate'][$key][1] = 0;
                }
            }
        }else{
            $result['clickrate'] = [0,0];
        }
        return $result['clickrate'];
    }

    public function loadOpenRate(){
        $i = 0;
        $j = 0;
        $open_emails = DB::table('sent_emails')
        ->select((DB::raw('DATE_FORMAT(sent_emails.created_at,"%Y%m%d") as date')),DB::raw('count(*) as nb_opens'))
        ->where('opens','>=', 1)
        ->groupBy('date')
        ->get()->toArray();

        $sent_emails = DB::table('sent_emails')
        ->select((DB::raw('DATE_FORMAT(sent_emails.created_at,"%Y%m%d") as date')),DB::raw('count(*) as nb_emails'))
        ->groupBy('date')
        ->get()->toArray();

        if (!empty($sent_emails)) {
            foreach ($sent_emails as $key => $value) {
                $result['sent'][$key][0] = $sent_emails[$key]->date;
                $result['sent'][$key][1] = $sent_emails[$key]->nb_emails;
            }

            if (!empty($open_emails)) {
                foreach ($open_emails as $key => $value) {
                    $result['open'][$key][0] = $open_emails[$key]->date;
                    $result['open'][$key][1] = $open_emails[$key]->nb_opens;
                }
            }
            $result['openrate'] = $result['sent'];
            foreach ($result['openrate'] as $key => $value) {
                $result['openrate'][$key][0] = $result['sent'][$key][0];
                if (!empty($open_emails) && $result['openrate'][$key][1]!=='0') {
                    foreach ($result['open'] as $k => $v) {
                        if ($result['openrate'][$key][0]===$result['open'][$k][0]) {
                            $i++;
                            $j = 0;
                           $result['openrate'][$key][1] = round($result['open'][$k][1]/$result['openrate'][$key][1]*100,1);
                           break; 
                        }else{
                            $j++;
                        }
                    }
                    if ($j!=0) {
                        $result['openrate'][$key][1] = 0;
                    }
                }
            }
            }else{
            $result['openrate'] = [0,0];
        }
        return $result['openrate'];
        }

    public function getFilterCategory(string $category)
    {
        $shown = DB::table('filter_category')->where('name', $category)->value('shown');
        return $shown;
    }

    public function getFilterCategoryPosition(string $category)
    {
        $position = DB::table('filter_category')->where('name', $category)->value('position');
        return $position;
    }

    public function setFilterCategory(Request $request)
    {
        if ($request->shown===1) {
            DB::table('filter_category')
            ->where('id', $request->id)
            ->update(['shown' => 1]);   
        }else{
          DB::table('filter_category')
          ->where('id', $request->id)
          ->update(['shown' => 0]);
          $position = DB::table('filter_category')->where('id', $request->id)->value('position');
          if ($position!==0) {
           DB::table('filter_category')
          ->where('position','>', $position)
          ->decrement('position',1);
          DB::table('filter_category')
          ->where('id', $request->id)
          ->update(['position' => 6]);   
          }  
      }
    }
    public function setFilterCategoryPosition($result, string $position,int $id1,int $id2)
    {
        switch ($position) {
            case 1:
                $result['dashboards'][$id1]->y=2;
                $result['dashboards'][$id2]->y=2;
                break;
            case 2:
                $result['dashboards'][$id1]->y=10;
                $result['dashboards'][$id2]->y=10;
                break;
            case 3:
                $result['dashboards'][$id1]->y=18;
                $result['dashboards'][$id2]->y=18;
                break;
            case 4:
                $result['dashboards'][$id1]->y=26;
                $result['dashboards'][$id2]->y=26;
                break;
            case 5:
                $result['dashboards'][$id1]->y=34;
                $result['dashboards'][$id2]->y=34;
                break;
            case 6:
                $result['dashboards'][$id1]->y=42;
                $result['dashboards'][$id2]->y=42;
                break;
        }
    }

    public function setFilterCategoryPositionById($dashboard)
    {
        switch ($dashboard['id']) {
            case 2:
                if ($dashboard['y']===2) {
                DB::table('filter_category')
                ->where('id', 3)
                ->update(['position' => 1]);
            }elseif ($dashboard['y']===10) {
              DB::table('filter_category')
              ->where('id', 3)
              ->update(['position' => 2]);
          }elseif ($dashboard['y']===18) {
             DB::table('filter_category')
             ->where('id', 3)
             ->update(['position' => 3]);
         }elseif ($dashboard['y']===26) {
             DB::table('filter_category')
             ->where('id', 3)
             ->update(['position' => 4]);
         }elseif ($dashboard['y']===34) {
             DB::table('filter_category')
             ->where('id', 3)
             ->update(['position' => 5]);
         }elseif ($dashboard['y']===42) {
             DB::table('filter_category')
             ->where('id', 3)
             ->update(['position' => 6]);
         }
         break;
            case 3:
                if ($dashboard['y']===2) {
                DB::table('filter_category')
                ->where('id', 4)
                ->update(['position' => 1]);
            }elseif ($dashboard['y']===10) {
              DB::table('filter_category')
              ->where('id', 4)
              ->update(['position' => 2]);
          }elseif ($dashboard['y']===18) {
             DB::table('filter_category')
             ->where('id', 4)
             ->update(['position' => 3]);
         }elseif ($dashboard['y']===26) {
             DB::table('filter_category')
             ->where('id', 4)
             ->update(['position' => 4]);
         }elseif ($dashboard['y']===34) {
             DB::table('filter_category')
             ->where('id', 4)
             ->update(['position' => 5]);
         }elseif ($dashboard['y']===42) {
             DB::table('filter_category')
             ->where('id', 4)
             ->update(['position' => 6]);
         }
         break;
            case 4:
                if ($dashboard['y']===2) {
                DB::table('filter_category')
                ->where('id', 6)
                ->update(['position' => 1]);
            }elseif ($dashboard['y']===10) {
              DB::table('filter_category')
              ->where('id', 6)
              ->update(['position' => 2]);
          }elseif ($dashboard['y']===18) {
             DB::table('filter_category')
             ->where('id', 6)
             ->update(['position' => 3]);
         }elseif ($dashboard['y']===26) {
             DB::table('filter_category')
             ->where('id', 6)
             ->update(['position' => 4]);
         }elseif ($dashboard['y']===34) {
             DB::table('filter_category')
             ->where('id', 6)
             ->update(['position' => 5]);
         }elseif ($dashboard['y']===42) {
             DB::table('filter_category')
             ->where('id', 6)
             ->update(['position' => 6]);
         }
         break;
            case 5:
                if ($dashboard['y']===2) {
                DB::table('filter_category')
                ->where('id', 6)
                ->update(['position' => 1]);
            }elseif ($dashboard['y']===10) {
              DB::table('filter_category')
              ->where('id', 6)
              ->update(['position' => 2]);
          }elseif ($dashboard['y']===18) {
             DB::table('filter_category')
             ->where('id', 6)
             ->update(['position' => 3]);
         }elseif ($dashboard['y']===26) {
             DB::table('filter_category')
             ->where('id', 6)
             ->update(['position' => 4]);
         }elseif ($dashboard['y']===34) {
             DB::table('filter_category')
             ->where('id', 6)
             ->update(['position' => 5]);
         }elseif ($dashboard['y']===42) {
             DB::table('filter_category')
             ->where('id', 6)
             ->update(['position' => 6]);
         }
         break;
            case 6:
                if ($dashboard['y']===2) {
                DB::table('filter_category')
                ->where('id', 3)
                ->update(['position' => 1]);
            }elseif ($dashboard['y']===10) {
              DB::table('filter_category')
              ->where('id', 3)
              ->update(['position' => 2]);
          }elseif ($dashboard['y']===18) {
             DB::table('filter_category')
             ->where('id', 3)
             ->update(['position' => 3]);
         }elseif ($dashboard['y']===26) {
             DB::table('filter_category')
             ->where('id', 3)
             ->update(['position' => 4]);
         }elseif ($dashboard['y']===34) {
             DB::table('filter_category')
             ->where('id', 3)
             ->update(['position' => 5]);
         }elseif ($dashboard['y']===42) {
             DB::table('filter_category')
             ->where('id', 3)
             ->update(['position' => 6]);
         }
         break;
            case 11:
                if ($dashboard['y']===2) {
                DB::table('filter_category')
                ->where('id', 2)
                ->update(['position' => 1]);
            }elseif ($dashboard['y']===10) {
              DB::table('filter_category')
              ->where('id', 2)
              ->update(['position' => 2]);
          }elseif ($dashboard['y']===18) {
             DB::table('filter_category')
             ->where('id', 2)
             ->update(['position' => 3]);
         }elseif ($dashboard['y']===26) {
             DB::table('filter_category')
             ->where('id', 2)
             ->update(['position' => 4]);
         }elseif ($dashboard['y']===34) {
             DB::table('filter_category')
             ->where('id', 2)
             ->update(['position' => 5]);
         }elseif ($dashboard['y']===42) {
             DB::table('filter_category')
             ->where('id', 2)
             ->update(['position' => 6]);
         }
         break;
            case 13:
                if ($dashboard['y']===2) {
                DB::table('filter_category')
                ->where('id', 5)
                ->update(['position' => 1]);
            }elseif ($dashboard['y']===10) {
              DB::table('filter_category')
              ->where('id', 5)
              ->update(['position' => 2]);
          }elseif ($dashboard['y']===18) {
             DB::table('filter_category')
             ->where('id', 5)
             ->update(['position' => 3]);
         }elseif ($dashboard['y']===26) {
             DB::table('filter_category')
             ->where('id', 5)
             ->update(['position' => 4]);
         }elseif ($dashboard['y']===34) {
             DB::table('filter_category')
             ->where('id', 5)
             ->update(['position' => 5]);
         }elseif ($dashboard['y']===42) {
             DB::table('filter_category')
             ->where('id', 5)
             ->update(['position' => 6]);
         }
         break;
            case 14:
                if ($dashboard['y']===2) {
                DB::table('filter_category')
                ->where('id', 2)
                ->update(['position' => 1]);
            }elseif ($dashboard['y']===10) {
              DB::table('filter_category')
              ->where('id', 2)
              ->update(['position' => 2]);
          }elseif ($dashboard['y']===18) {
             DB::table('filter_category')
             ->where('id', 2)
             ->update(['position' => 3]);
         }elseif ($dashboard['y']===26) {
             DB::table('filter_category')
             ->where('id', 2)
             ->update(['position' => 4]);
         }elseif ($dashboard['y']===34) {
             DB::table('filter_category')
             ->where('id', 2)
             ->update(['position' => 5]);
         }elseif ($dashboard['y']===42) {
             DB::table('filter_category')
             ->where('id', 2)
             ->update(['position' => 6]);
         }
         break;
            case 19:
                if ($dashboard['y']===2) {
                DB::table('filter_category')
                ->where('id', 4)
                ->update(['position' => 1]);
            }elseif ($dashboard['y']===10) {
              DB::table('filter_category')
              ->where('id', 4)
              ->update(['position' => 2]);
          }elseif ($dashboard['y']===18) {
             DB::table('filter_category')
             ->where('id', 4)
             ->update(['position' => 3]);
         }elseif ($dashboard['y']===26) {
             DB::table('filter_category')
             ->where('id', 4)
             ->update(['position' => 4]);
         }elseif ($dashboard['y']===34) {
             DB::table('filter_category')
             ->where('id', 4)
             ->update(['position' => 5]);
         }elseif ($dashboard['y']===42) {
             DB::table('filter_category')
             ->where('id', 4)
             ->update(['position' => 6]);
         }
         break;
            case 20:
                if ($dashboard['y']===2) {
                DB::table('filter_category')
                ->where('id', 5)
                ->update(['position' => 1]);
            }elseif ($dashboard['y']===10) {
              DB::table('filter_category')
              ->where('id', 5)
              ->update(['position' => 2]);
          }elseif ($dashboard['y']===18) {
             DB::table('filter_category')
             ->where('id', 5)
             ->update(['position' => 3]);
         }elseif ($dashboard['y']===26) {
             DB::table('filter_category')
             ->where('id', 5)
             ->update(['position' => 4]);
         }elseif ($dashboard['y']===34) {
             DB::table('filter_category')
             ->where('id', 5)
             ->update(['position' => 5]);
         }elseif ($dashboard['y']===42) {
             DB::table('filter_category')
             ->where('id', 5)
             ->update(['position' => 6]);
         }
         break;
         case 21:
                if ($dashboard['y']===2) {
                DB::table('filter_category')
                ->where('id', 7)
                ->update(['position' => 1]);
            }elseif ($dashboard['y']===10) {
              DB::table('filter_category')
              ->where('id', 7)
              ->update(['position' => 2]);
          }elseif ($dashboard['y']===18) {
             DB::table('filter_category')
             ->where('id', 7)
             ->update(['position' => 3]);
         }elseif ($dashboard['y']===26) {
             DB::table('filter_category')
             ->where('id', 7)
             ->update(['position' => 4]);
         }elseif ($dashboard['y']===34) {
             DB::table('filter_category')
             ->where('id', 7)
             ->update(['position' => 5]);
         }elseif ($dashboard['y']===42) {
             DB::table('filter_category')
             ->where('id', 7)
             ->update(['position' => 6]);
         }
         break;
         case 22:
                if ($dashboard['y']===2) {
                DB::table('filter_category')
                ->where('id', 7)
                ->update(['position' => 1]);
            }elseif ($dashboard['y']===10) {
              DB::table('filter_category')
              ->where('id', 7)
              ->update(['position' => 2]);
          }elseif ($dashboard['y']===18) {
             DB::table('filter_category')
             ->where('id', 7)
             ->update(['position' => 3]);
         }elseif ($dashboard['y']===26) {
             DB::table('filter_category')
             ->where('id', 7)
             ->update(['position' => 4]);
         }elseif ($dashboard['y']===34) {
             DB::table('filter_category')
             ->where('id', 7)
             ->update(['position' => 5]);
         }elseif ($dashboard['y']===42) {
             DB::table('filter_category')
             ->where('id', 7)
             ->update(['position' => 6]);
         }
         break;
        }
    }
}
