<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Repositories\Backend\Access\User\UserRepository;
use App\Repositories\Frontend\Offers\OffersRepository;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use App\Services\Flag\Src\Flag;
use Illuminate\Translation\Translator;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Dashboard\Repositories\Contracts\DashboardRepository;
use Modules\Wishes\Repositories\Contracts\WishesRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;
use Analytics;
use Spatie\Analytics\Period;
use Modules\Dashboard\Exports\DashboardExport;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    /**
     * @var \Modules\Dashboard\Repositories\Contracts\DashboardRepository
     */
    private $dashboard;
    /**
     * @var \Modules\Activities\Repositories\Contracts\ActivitiesRepository
     */
    private $activities;
    /**
     * @var \Illuminate\Routing\ResponseFactory
     */
    private $response;
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;
    /**
     * @var \Illuminate\Translation\Translator
     */
    private $lang;
    /**
     * @var \App\Repositories\Backend\Access\User\UserRepository
     */
    private $users;
    /**
     * @var \Illuminate\Support\Carbon
     */
    private $carbon;
    /**
     * @var \Modules\Wishes\Repositories\Contracts\WishesRepository
     */
    private $wishes;
    /**
     * @var \App\Repositories\Frontend\Offers\OffersRepository
     */
    private $offers;

    private $whitelabels;

    /**
     * DashboardController constructor.
     *
     * @param \Modules\Dashboard\Repositories\Contracts\DashboardRepository   $dashboard
     * @param \Modules\Activities\Repositories\Contracts\ActivitiesRepository $activities
     * @param \Illuminate\Routing\ResponseFactory                             $response
     * @param \Illuminate\Auth\AuthManager                                    $auth
     * @param \Illuminate\Translation\Translator                              $lang
     * @param \App\Repositories\Backend\Access\User\UserRepository            $users
     * @param \Illuminate\Support\Carbon                                      $carbon
     */
    public function __construct(DashboardRepository $dashboard, ActivitiesRepository $activities, ResponseFactory $response, AuthManager $auth, Translator $lang, UserRepository $users, Carbon $carbon, WishesRepository $wishes, OffersRepository $offers,WhitelabelsRepository $whitelabels)
    {
        $this->dashboard = $dashboard;
        $this->activities = $activities;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->users = $users;
        $this->carbon = $carbon;
        $this->wishes = $wishes;
        $this->offers = $offers;
        $this->whitelabels = $whitelabels;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {   
        return view('dashboard::index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('dashboard::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        try {
            $result['dashboards'] = $this->auth->guard('web')->user()->dashboards()->get();

            $result['p_desktop'] = $this->dashboard->getFilterCategoryPosition('LI Desktop');
            $this->dashboard->setFilterCategoryPosition($result,$result['p_desktop'],1,5);
            $result['p_mobile'] = $this->dashboard->getFilterCategoryPosition('LI Mobile');
            $this->dashboard->setFilterCategoryPosition($result,$result['p_mobile'],2,12);
            $result['p_wunsch'] = $this->dashboard->getFilterCategoryPosition('Wünsche');
            $this->dashboard->setFilterCategoryPosition($result,$result['p_wunsch'],9,11);
            $result['p_browser'] = $this->dashboard->getFilterCategoryPosition('Desktop Browser');
            $this->dashboard->setFilterCategoryPosition($result,$result['p_browser'],10,13);
            $result['p_response'] = $this->dashboard->getFilterCategoryPosition('Response Rate');
            $this->dashboard->setFilterCategoryPosition($result,$result['p_response'],3,4);
            $result['p_email'] = $this->dashboard->getFilterCategoryPosition('E-Mail');
            $this->dashboard->setFilterCategoryPosition($result,$result['p_email'],14,15);

            $result['limobile'] = $this->dashboard->getFilterCategory('LI Mobile');
            $result['lidesktop'] = $this->dashboard->getFilterCategory('LI Desktop');
            $result['wunsch'] = $this->dashboard->getFilterCategory('Wünsche');
            $result['browser'] = $this->dashboard->getFilterCategory('Desktop Browser');
            $result['response'] = $this->dashboard->getFilterCategory('Response Rate');
            $result['basis'] = $this->dashboard->getFilterCategory('Basis');
            $result['email'] = $this->dashboard->getFilterCategory('E-Mail');
            
            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        return view('dashboard::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function update(Request $request)
    {
    }

    public function save(Request $request)
    {
        try {
            $dashboards = $this->auth->guard('web')->user()->dashboards()->get()->pluck('id')->toArray();

            foreach ($request->get('dashboards') as $dashboard) {
                if (\in_array($dashboard['id'], $dashboards, true)) {
                    $this->dashboard->update($dashboard['id'], ['x' => $dashboard['x'], 'y' => $dashboard['y']]);
                    $this->dashboard->setFilterCategoryPositionById($dashboard);
                }
            }
            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy()
    {
    }

    public function export(Request $request)
    {
        return new DashboardExport($this->dashboard,$this->wishes,$this->carbon);
    }

    public function exportw(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabelId');
            $startDate = is_null($request->get('start')) ? '' : $request->get('start');
            $endDate = is_null($request->get('end')) ? '' : $request->get('end');

            if (is_null($whitelabelId)) {
                $whitelabel = $this->whitelabels->first();
            } else {
                $whitelabel = $this->whitelabels->find($whitelabelId);
            }

            $viewId = is_null($whitelabel['ga_view_id']) ? '192484069' : $whitelabel['ga_view_id'];

            $file = storage_path().'/test.txt';
            $current = file_get_contents($file);
            $current = $viewId."\n";
            $current .= $whitelabelId."\n";
            $current .= $startDate."\n";
            $current .= $endDate;
            file_put_contents($file, $current); 

            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

    }
    /**
     * Google analytics.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function googleAnalytics(Request $request)
    {
        try {
            $whitelabelId = $request->get('whitelabel');

            $gaViewId = null;
            // TODO: add to db - whitelabels
            switch ($whitelabelId) {
                case 1:
                    $gaViewId = '159641355';
                    break;
                case 2:
                    $gaViewId = '163819320';
                    break;
                case 3:
                    $gaViewId = '162076862';
                    break;
                case 4:
                    $gaViewId = '';
                    break;
                case 5:
                    $gaViewId = '';
                    break;
                case 15:
                    $gaViewId = '185523513';
                    break;
            }

            if ('' !== $gaViewId) {
                $optParams = [
                    'dimensions' => 'rt:eventLabel, rt:eventCategory, rt:eventAction'
                ];

                $result['ga'] = \Analytics::getAnalyticsService()->data_realtime->get(
                    'ga:' . $gaViewId,
                    'rt:totalEvents',
                    $optParams
                );

                $data = [];

                foreach ($result['ga']->getRows() as $row) {
                    $item = [
                        'rt:eventLabel'    => $row[0],
                        'rt:eventCategory' => $row[1],
                        'rt:eventAction'   => $row[2]
                    ];

                    array_push($data, $item);
                }

                $result['data'] = $data;
            } else {
                $result['data'] = [];
            }

            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    /**
     * Backend analytics.
     *
     * @return Response
     */
    public function backendAnalytics()
    {
        try {
            $date = new \DateTime();
            $date->modify('-48 hours');
            $formattedDate = $date->format('Y-m-d H:i:s');

            $wishes = $this->wishes->all()->count();
            $changedWishes = $this->wishes->findWhereRaw('created_at != updated_at')->count();
            $freeText = $this->wishes->findWhereRaw('description != ""')->count();
            $answeredWishes = $this->offers->getCount();
            $reactionQuota = $answeredWishes / $wishes * 100;
            $latestAnsweredWishes = $this->offers->findWhere('created_at', '>', $formattedDate)->count();
            $latestReactionQuota = $latestAnsweredWishes / $wishes * 100;
            $bookings = $this->wishes->findWhereRaw('booking_status = "booked"')->count();

            $wishesWithOffers = $this->wishes->getWithRelation(['offers']);

            $wishesWithReactionTime = [];
            foreach ($wishesWithOffers as $wo) {
                if (\count($wo->offers) > 0) {
                    $wishDate = Carbon::parse($wo->created_at);
                    $offerDate = Carbon::parse($wo->offers[0]->created_at);
                    $diffInHours = $wishDate->diffInHours($offerDate);
                    $wo['diff_hours'] = $diffInHours;
                    array_push($wishesWithReactionTime, $wo);
                }
            }

            $data = [
                'created_wishes'         => $wishes,
                'changed_wishes'         => $changedWishes,
                'free_text'              => $freeText,
                'answered_wishes'        => $answeredWishes,
                'reaction_quota'         => $reactionQuota . '%',
                'latest_answered_wishes' => $latestAnsweredWishes,
                'latest_reaction_quota'  => $latestReactionQuota . '%',
                'reaction_time'          => $wishesWithReactionTime,
                'bookings'               => $bookings
            ];

            $result['data'] = $data;

            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }
}
