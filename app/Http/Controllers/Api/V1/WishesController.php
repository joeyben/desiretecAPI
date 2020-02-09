<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Frontend\Wishes\ChangeWishesStatusRequest;
use App\Http\Requests\Frontend\Wishes\ManageWishesRequest;
use App\Http\Requests\Frontend\Wishes\UpdateNoteRequest;
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
use App\Repositories\Frontend\Wishes\WishesRepository;
use Validator;
use Auth;

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
     * @var \App\Repositories\Backend\Groups\GroupsRepository
     */
    private $groups;
    /**
     * @var \App\Repositories\Frontend\Wishes\WishesRepository
     */
    private $repository;

    public function __construct(WishesRepository $repository, ChannelManager $notification, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, GroupsRepository $groups)
    {
        $this->repository = $repository;
        $this->notification = $notification;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
        $this->groups = $groups;
    }

    public function getWishes(Request $request)
    {
        try {
            [$perPage, $sort, $search] = $this->parseRequest($request);

            $result['data'] = $this->repository->withCriteria([
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
    public function getWish(int $id, Request $request)
    {
        try {
            $user = Auth::guard('api')->user();
            $wish = $this->repository->getById($id);
            $result['data'] = $wish;

            if ($user->hasRole('User') && $wish->created_by === $user->id) {
                return $this->responseJson($result);
            } else if(($user->hasRole('Seller') && in_array($wish->group_id, $user->groups->pluck('id')->toArray()))) {
                return $this->responseJson($result);
            }

            return $this->respondUnauthorized();
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    public function wishlist(ManageWishesRequest $request){
        try {
            return $this->responseJson($this->repository->getWishList($request));
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    public function changeWishStatus(ChangeWishesStatusRequest $request){
        try {
            return $this->responseJson($this->repository->changeWishStatus($request)->original);
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    public function updateNote(UpdateNoteRequest $request) {
        try {
            $this->repository->updateNote($request->get('id'), $request->get('note') ?? '');

            return $this->respondUpdated();
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    /**
     *
     */
    public function store(StoreWishesRequest $request)
    {
        try{
            if ($this->wishes->createFromApi($request->all())){
                return $this->respondCreated(trans('alerts.frontend.wish.created'));
            }

            return $this->respondWithError('error');
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }
}
