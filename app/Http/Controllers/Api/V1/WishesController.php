<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Frontend\Wishes\ChangeWishesStatusRequest;
use App\Http\Requests\Frontend\Wishes\ManageWishesRequest;
use App\Http\Requests\Frontend\Wishes\StoreWishesRequest;
use App\Http\Requests\Frontend\Wishes\UpdateNoteRequest;
use App\Jobs\callTTApi;
use App\Jobs\sendAutoOffersMail;
use App\Models\Agents\Agent;
use App\Models\Wishes\Wish;
use App\Repositories\Backend\Groups\GroupsRepository;
use App\Repositories\Criteria\ByUserRole;
use App\Repositories\Criteria\ByWhitelabel;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Filter;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Where;
use App\Repositories\Frontend\Access\User\UserRepository;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Auth;
use Illuminate\Auth\AuthManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;
use Modules\Categories\Repositories\Contracts\CategoriesRepository;
use Modules\Whitelabels\Repositories\Contracts\LayerWhitelabelRepository;

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
    /**
     * @var \Modules\Categories\Repositories\Contracts\CategoriesRepository
     */
    private $categories;
    /**
     * @var \Modules\Whitelabels\Repositories\Contracts\LayerWhitelabelRepository
     */
    private $layerWhitelabel;

    public function __construct(WishesRepository $repository, ChannelManager $notification, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, GroupsRepository $groups, CategoriesRepository $categories, LayerWhitelabelRepository $layerWhitelabel)
    {
        $this->repository = $repository;
        $this->notification = $notification;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
        $this->groups = $groups;
        $this->categories = $categories;
        $this->layerWhitelabel = $layerWhitelabel;
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
            $data = $this->repository->getById($id);
            $wishData = $data['wish'];
            $avatar = [];
            $agentName = [];
            $lastMessage = count($wishData->messages) ? $wishData->messages[count($wishData->messages) - 1] : null;
            $lastOffer = count($wishData->offers) ? $wishData->offers[count($wishData->offers) - 1] : null;
            $lastAgent = $lastMessage ? $lastMessage->agent_id : null;
            $lastAgent = ($lastOffer && $lastMessage && $lastOffer->created_at > $lastMessage->created_at )  ? $lastOffer->agent_id : $lastAgent;
            $agents =  isset($wishData->group->users[0]->agents) ? $wishData->group->users[0]->agents : [];
            $wishData->setAttribute('lastAgent', null);
            $offers = $wishData->offers;
            $offerFiles = [];
            foreach ($offers as $key => $offer) {
                if (null !== Agent::where('id', $offer->agent_id)->value('avatar')) {
                    array_push($avatar, Agent::where('id', $offer->agent_id)->value('avatar'));
                }

                if (null !== Agent::where('id', $offer->agent_id)->first()) {
                    $agent =  Agent::where('id', $offer->agent_id)->first();
                    array_push($agentName, $agent);
                    $wishData->offers[$key]->setAttribute('agent', $agent);
                }

                if (!$offer->offerFiles->isEmpty()) {
                    array_push($offerFiles, $offer->offerFiles);
                }
            }
            foreach ($agents as $key => $agent) {
                if($agent->id == $lastAgent){
                    $wishData->lastAgent = $agent;
                }
            }

            if (!$wishData->lastAgent) {
                $wishData->lastAgent = $agents->first();
            }

            $wish = $data['modifiedData'];
            $result['data'] = $wish;
            $result['data']['wish_id'] = $id;
            $result['data']['avatar'] = $avatar;
            $result['data']['agent'] = \Illuminate\Support\Facades\Auth::guard('agent')->user();
            $result['data']['agent_name'] = $agentName;
            $result['data']['offerFiles'] = $offerFiles;
            $result['data']['layer_image'] = $this->getLayerImage($wishData->whitelabel_id, $wishData->version);
            $result['data']['wishDetails'] = $wishData;
            $result['data']['wishDetails']['catering'] = $this->categories->getCategoryByParentValue('catering', $wish->catering);
            $result['data']['wishDetails']['duration'] = transformDuration($wishData->duration);
            $result['data']['wishDetails']['purpose'] = transformTravelPurpose($wishData->purpose);
            $result['data']['wishDetails']['owner'] = $wishData->owner;
            $result['data']['wishDetails']['messages'] = $wishData->messages;
            $result['data']['wishDetails']['contacts'] = $wishData->contacts;
            $result['data']['wishDetails']['callbacks'] = $wishData->callbacks;
            $result['data']['wishDetails']['group'] = $wishData->group;
            $result['data']['wishDetails']['group']['users'] = $wishData->group->users;
            $result['data']['wishDetails']['group']['agents'] = $agents;

            return $this->responseJson($result);
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    public function wishlist(ManageWishesRequest $request)
    {
        try {
            return $this->responseJson($this->repository->getWishList($request));
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    public function changeWishStatus(ChangeWishesStatusRequest $request)
    {
        try {
            return $this->responseJson($this->repository->changeWishStatus($request)->original);
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    public function updateNote(UpdateNoteRequest $request)
    {
        try {
            $this->repository->updateNote($request->get('id'), $request->get('note') ?? '');

            return $this->respondUpdated();
        } catch (Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    public function store(StoreWishesRequest $request, UserRepository $user)
    {
        try {
            if ($request->hasHeader('wl-locale') && null !== $request->header('wl-locale')) {
                session()->put('wl-locale', $request->header('wl-locale'));
                session()->put('wl-id', $request->header('wl-id'));
            }

            $newUser = $user->createUserFromLayer(
                $request->only('first_name', 'last_name', 'email', 'password', 'is_term_accept', 'terms'),
                $request->input('whitelabel_id')
            );
            $input = $request->all();

            $ages1 = isset($input['ages1']) ? $input['ages1'] . ',' : '';
            $ages2 = isset($input['ages2']) ? $input['ages2'] . ',' : '';
            $ages3 = isset($input['ages3']) ? $input['ages3'] . ',' : '';
            $ages4 = isset($input['ages4']) ? $input['ages4'] : '';
            $ages = $ages1 . $ages2 . $ages3 . $ages4;
            $whitelabel = getWhitelabelById((int) $request->input('whitelabel_id'));
            $request->merge([
                'ages'           => $ages
            ]);

            if ($wish = $this->repository->createFromApi($request->except('variant', 'first_name', 'last_name', 'email',
                'password', 'is_term_accept', 'name', 'terms', 'ages1', 'ages2', 'ages3', 'ages4'), $newUser->id)) {

                if ($wish->whitelabel->tt && $this->repository->manageRules($wish) > 0) {
                    $this->repository->setIsAutoofer($wish->id);
                    $this->callTT($wish, $newUser, $request);
                } elseif ($wish->whitelabel->traffics && $this->repository->manageRules($wish) > 0) {
                    $this->repository->setIsAutoofer($wish->id);
                    $this->callTraffics($wish, $newUser, $request);
                }
                elseif ($wish->whitelabel->peakwork) {
                    $this->repository->setIsAutoofer($wish->id);
                    $this->callPeakwork($wish, $newUser, $request);
                }

                return $this->respondCreated(trans('alerts.frontend.wish.created'));
            }

            return $this->respondWithError('error');
        } catch (\Exception $e) {
            return $this->respondWithError($e->getMessage());
        }
    }

    public function callTT($wish, $newUser, $request)
    {
        $view = \View::make('wishes::emails.autooffer',
            [
                'url'=> $wish->whitelabel->domain . '/offer/ttlist/' . $wish->id . '/' . $newUser->token->token,
                'whitelabelId' => $wish->whitelabel->id,
                'whitelabel' => $wish->whitelabel
            ]
        );
        $contents = $view->render();

        //$wishJob = (new callTTApi($wish->id, $request->input('whitelabel_id'), $newUser->id))->delay(Carbon::now()->addSeconds(3));
        //dispatch($wishJob);

        $this->repository->callTT($wish->id, $request->input('whitelabel_id'), $newUser->id);

        $details = [
            'email'            => $newUser->email,
            'token'            => $newUser->token->token,
            'email_name'       => trans('autooffers.email.name'),
            'email_subject'    => trans('autooffer.email.subject'),
            'email_content'    => $contents,
            'current_wl_email' => $wish->whitelabel->email,
            'type'             => 0
        ];
        dispatch((new sendAutoOffersMail($details, $wish->id, $wish->whitelabel->email))->delay(Carbon::now()->addSeconds(1)));
    }

    public function callTraffics($wish, $newUser, $request)
    {
        $view = \View::make('wishes::emails.autooffer',
            [
                'url'=> $wish->whitelabel->domain . '/offer/list/' . $wish->id . '/' . $newUser->token->token,
                'whitelabelId' => $wish->whitelabel->id,
                'whitelabel' => $wish->whitelabel
            ]
        );
        $contents = $view->render();

        //$wishJob = (new callTTApi($wish->id, $request->input('whitelabel_id'), $newUser->id))->delay(Carbon::now()->addSeconds(3));
        //dispatch($wishJob);

        $this->repository->callTraffics($wish->id, $request->input('whitelabel_id'), $newUser->id);

        $details = [
            'email'            => $newUser->email,
            'token'            => $newUser->token->token,
            'email_name'       => trans('autooffers.email.name'),
            'email_subject'    => trans('autooffer.email.subject'),
            'email_content'    => $contents,
            'current_wl_email' => $wish->whitelabel->email,
            'type'             => 0
        ];
        dispatch((new sendAutoOffersMail($details, $wish->id, $wish->whitelabel->email))->delay(Carbon::now()->addSeconds(1)));
    }

    public function callPeakwork($wish, $newUser, $request)
    {
        $view = \View::make('wishes::emails.autooffer',
            [
                'url'=> $wish->whitelabel->domain . '/offer/list/' . $wish->id . '/' . $newUser->token->token,
                'whitelabelId' => $wish->whitelabel->id,
                'whitelabel' => $wish->whitelabel
            ]
        );
        $contents = $view->render();

        //$wishJob = (new callTTApi($wish->id, $request->input('whitelabel_id'), $newUser->id))->delay(Carbon::now()->addSeconds(3));
        //dispatch($wishJob);

        $this->repository->callPeakwork($wish->id, $request->input('whitelabel_id'), $newUser->id);

        $details = [
            'email'            => $newUser->email,
            'token'            => $newUser->token->token,
            'email_name'       => trans('autooffers.email.name'),
            'email_subject'    => trans('autooffer.email.subject'),
            'email_content'    => $contents,
            'current_wl_email' => $wish->whitelabel->email,
            'type'             => 0
        ];
        dispatch((new sendAutoOffersMail($details, $wish->id, $wish->whitelabel->email))->delay(Carbon::now()->addSeconds(1)));
    }

    private function getLayerImage($whitelabelId, $layerName) {

        $whitelabelLayers = $this->getWhitelabelLayers($whitelabelId);

        foreach ($whitelabelLayers as $layer) {
            if ($layer['layer']['path'] === $layerName) {
                return $layer['visual'];
            }
        }
    }

    private function getWhitelabelLayers(int $whitelabelId) {

        $layers = $this->layerWhitelabel->withCriteria([
            new OrderBy('layer_id'),
            new Where('whitelabel_id', $whitelabelId),
            new EagerLoad(['layer', 'attachments', 'variants'  => function ($query) {
                $query->where('variants.active', 1)->with('attachments');
            }])
        ])->all();

        return  $layers->map(function ($layer) {
            return [
                'visual' => $this->getImage($layer, 'visual'),
                'layer' => $layer->layer,
            ];
        });
    }

    private function getImage($layer, $type)
    {
        $default = 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/visual/default_layer_package.png';
        $url = '';
        $variant = $layer->variants->first();

        if ($variant) {
            $attachments = $variant->attachments->map(function ($attachment) {
                return [
                    'url' => $attachment->url,
                    'type' => $attachment->type
                ];
            });

            foreach ($attachments as    $attachment) {
                if ($attachment['type'] === 'variants/' . $type) {
                    $url = $attachment['url'];
                }
            }

            if ($url !== '')
            {
                return $url;
            } else {
                return $default;
            }

        } else if ($type === 'visual') {
            if ($image = $layer->attachments->first()) {
                return $image->url;
            }

            return $default;
        } else {
            return $default;
        }
    }
}
