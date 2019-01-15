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
use Illuminate\Translation\Translator;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Dashboard\Repositories\Contracts\DashboardRepository;
use Modules\Wishes\Repositories\Contracts\WishesRepository;

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
    public function __construct(DashboardRepository $dashboard, ActivitiesRepository $activities, ResponseFactory $response, AuthManager $auth, Translator $lang, UserRepository $users, Carbon $carbon, WishesRepository $wishes, OffersRepository $offers)
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
            $whitelabel_id = $request->get('whitelabel');

            $ga_view_id = null;
            // TODO: add to db - whitelabels
            switch ($whitelabel_id) {
                case 1:
                    $ga_view_id = '159641355';
                    break;
                case 2:
                    $ga_view_id = '163819320';
                    break;
                case 3:
                    $ga_view_id = '162076862';
                    break;
                case 4:
                    $ga_view_id = '';
                    break;
                case 5:
                    $ga_view_id = '';
                    break;
                case 15:
                    $ga_view_id = '185523513';
                    break;
            }

            if ($ga_view_id != '') {
                $optParams = array(
                    'dimensions' => 'rt:eventLabel, rt:eventCategory, rt:eventAction'
                );

                $result['ga'] = \Analytics::getAnalyticsService()->data_realtime->get(
                    'ga:' . $ga_view_id,
                    'rt:totalEvents',
                    $optParams
                );

                $data = array();

                foreach ($result['ga']->getRows() as $row) {
                    $item = [
                        'rt:eventLabel' => $row[0],
                        'rt:eventCategory' => $row[1],
                        'rt:eventAction' => $row[2]
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
            $formatted_date = $date->format('Y-m-d H:i:s');

            $wishes = $this->wishes->all()->count();
            $changed_wishes = $this->wishes->findWhereRaw('created_at != updated_at')->count();
            $free_text = $this->wishes->findWhereRaw('description != ""')->count();
            $answered_wishes = $this->offers->getCount();
            $reaction_quota = $answered_wishes / $wishes * 100;
            $latest_answered_wishes = $this->offers->findWhere('created_at', '>', $formatted_date)->count();
            $latest_reaction_quota = $latest_answered_wishes / $wishes * 100;
            $bookings = $this->wishes->findWhereRaw('booking_status = "booked"')->count();

            $wishesWithOffers = $this->wishes->getWithRelation(['offers']);

            $wishesWithReactionTime = [];
            foreach ($wishesWithOffers as $wo) {
                if (count($wo->offers) > 0) {
                    $wishDate = Carbon::parse($wo->created_at);
                    $offerDate = Carbon::parse($wo->offers[0]->created_at);
                    $diffInHours = $wishDate->diffInHours($offerDate);
                    $wo['diff_hours'] = $diffInHours;
                    array_push($wishesWithReactionTime, $wo);
                }
            }


            $data = [
                'created_wishes' => $wishes,
                'changed_wishes' => $changed_wishes,
                'free_text' => $free_text,
                'answered_wishes' => $answered_wishes,
                'reaction_quota' => $reaction_quota . '%',
                'latest_answered_wishes' => $latest_answered_wishes,
                'latest_reaction_quota' => $latest_reaction_quota . '%',
                'reaction_time' => $wishesWithReactionTime,
                'bookings' => $bookings
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
