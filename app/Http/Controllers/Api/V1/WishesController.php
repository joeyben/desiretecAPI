<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Wishes\Wish;
use App\Repositories\Backend\Groups\GroupsRepository;
use App\Repositories\Criteria\ByUser;
use App\Repositories\Criteria\ByUserRole;
use App\Repositories\Criteria\ByWhitelabel;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Where;
use App\Repositories\Criteria\WhereBetween;
use App\Repositories\Criteria\WithTrashed;
use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;
use Modules\Activities\Repositories\Contracts\ActivitiesRepository;
use Modules\Wishes\Repositories\Contracts\WishesRepository;
use Validator;

class WishesController extends APIController
{
    use AuthorizesRequests;
    /**
     * @var \Modules\Wishes\Repositories\Contracts\WishesRepository
     */
    private $wishes;
    /**
     * @var \Illuminate\Notifications\ChannelManager
     */
    private $notification;
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
     * @var \Illuminate\Support\Carbon
     */
    private $carbon;
    /**
     * @var \Modules\Activities\Repositories\Contracts\ActivitiesRepository
     */
    private $activities;
    /**
     * @var \App\Repositories\Backend\Groups\GroupsRepository
     */
    private $groups;

    public function __construct(WishesRepository $wishes, ChannelManager $notification, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, ActivitiesRepository $activities, GroupsRepository $groups)
    {
        $this->wishes = $wishes;
        $this->notification = $notification;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
        $this->activities = $activities;
        $this->groups = $groups;
    }

    public function getWishes(Request $request)
    {
        try {
            [$perPage, $sort, $search] = $this->parseRequest($request);

            $result['data'] = $this->wishes->withCriteria([
                new ByUserRole($this->auth->user()->id),
                new OrderBy($sort[0], $sort[1]),
                new Filter($search),
                new EagerLoad(['owner' => function ($query) {
                    $select = 'CONCAT(first_name, " ", last_name) AS full_name';
                    $query->select('id', DB::raw($select));
                }, 'group'  => function ($query) {
                    $query->select('id', 'display_name');
                }, 'whitelabel'  => function ($query) {
                    $query->select('id', 'display_name');
                }]),
                new ByWhitelabel()
            ])->paginate($perPage);

            return $this->responseJson($result);
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }

    }
    public function getWish(Wish $wish, Request $request)
    {
        try {

            $result['data'] = $this->wishes->withCriteria([
                new ByUserRole($this->auth->user()->id),
                new EagerLoad(['owner' => function ($query) {
                    $select = 'CONCAT(first_name, " ", last_name) AS full_name';
                    $query->select('id', DB::raw($select));
                }, 'group'  => function ($query) {
                    $query->select('id', 'display_name');
                }, 'whitelabel'  => function ($query) {
                    $query->select('id', 'display_name');
                }]),
                new ByWhitelabel()
            ])->find($wish->id);

            return $this->responseJson($result);
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }

    }
}
