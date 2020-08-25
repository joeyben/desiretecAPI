<?php

namespace Modules\LanguageLines\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Access\Role\Role;
use App\Repositories\Criteria\Where;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Response;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;
use Illuminate\Translation\Translator;
use Modules\LanguageLines\Entities\LanguageLines;
use Modules\LanguageLines\Http\Requests\FooterTnbStoreRequest;
use Modules\LanguageLines\Repositories\Contracts\LanguageLinesRepository;
use Modules\Languages\Repositories\Contracts\LanguagesRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

class TnbController extends Controller
{
    use AuthorizesRequests;

    /**
     * @var \Modules\LanguageLines\Repositories\Contracts\LanguageLinesRepository
     */
    private $languageline;
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
     * @var \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository
     */
    private $whitelabels;
    /**
     * @var \Illuminate\Database\DatabaseManager
     */
    private $database;
    /**
     * @var \Illuminate\Notifications\ChannelManager
     */
    private $notification;
    /**
     * @var \App\Models\Access\Role\Role
     */
    private $role;
    /**
     * @var \Modules\Languages\Repositories\Contracts\LanguagesRepository
     */
    private $languages;
    /**
     * @var \Illuminate\Contracts\Console\Kernel
     */
    private $artisan;

    /**
     * LanguageLines constructor.
     */
    public function __construct(LanguageLinesRepository $languageline, ResponseFactory $response, AuthManager $auth, Translator $lang, Carbon $carbon, WhitelabelsRepository $whitelabels, DatabaseManager $database, ChannelManager $notification, Role $role, LanguagesRepository $languages, Kernel $artisan)
    {
        $this->languageline = $languageline;
        $this->response = $response;
        $this->auth = $auth;
        $this->lang = $lang;
        $this->carbon = $carbon;
        $this->whitelabels = $whitelabels;
        $this->database = $database;
        $this->notification = $notification;
        $this->role = $role;
        $this->languages = $languages;
        $this->artisan = $artisan;
    }

    public function tnb(string $lang)
    {

        try {
            if (null === $this->auth->guard('web')->user()->whitelabels()->first()) {
                abort(403, trans('errors.user.nowhitelabel'));
            }

            if ($this->auth->guard('web')->user()->hasRole(Flag::EXECUTIVE_ROLE)) {
                $whiteLabelID = $this->auth->guard('web')->user()->whitelabels()->first()->id;
                $whiteLabelName = $this->auth->guard('web')->user()->whitelabels()->first()->display_name;
                $domain = $this->auth->guard('web')->user()->whitelabels()->first()->domain;


                $currentLanguageline = $this->languageline->withCriteria([
                    new Where('locale', $lang),
                    new Where('key', 'footer.tnb'),
                    new Where('group', 'layer_tnb'),
                    new Where('whitelabel_id', $whiteLabelID),
                ])->get();



                if (!$currentLanguageline->count()) {
                    $tnb = str_replace('$KUNDE', $whiteLabelName, Lang::get('tnb.tnb', [], $lang));
                    $tnb = str_replace('$URL-REISEWUNSCHPORTAL', $domain, $tnb);

                    $languageline = $this->languageline->create([
                        'locale' => $lang,
                        'key' => 'footer.tnb',
                        'group' => 'layer_tnb',
                        'text' => $tnb,
                        'whitelabel_id' => $whiteLabelID,
                    ]);
                } else {
                    $languageline = $this->languageline->withCriteria([
                        new Where('locale', $lang),
                        new Where('key', 'footer.tnb'),
                        new Where('group', 'layer_tnb'),
                        new Where('whitelabel_id', $whiteLabelID),
                    ])->first();

                }



                $result['data']['text'] = $languageline->text;

                LanguageLinesController::cacheFlush();
            } else {
                abort(403, trans('errors.user.noexecutiveuser'));
            }



            $result['data']['language'] = $lang;
            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return view('languagelines::footer-tnb', compact(['result']));
    }

    /**
     * Edit already existing Teilnahmebedingungen or Create new Teilnahmebedingungen.
     *
     * @return Response
     */
    public function tnbStore(FooterTnbStoreRequest $request)
    {
        try {
            if ($this->auth->guard('web')->user()->hasRole(Flag::ADMINISTRATOR_ROLE)) {
                return redirect(route('provider.footer.tnb', $request->language))->with('error', trans('User guard is different'));
            } elseif ($this->auth->guard('web')->user()->hasRole(Flag::EXECUTIVE_ROLE)) {
                $whiteLabelID = $this->auth->guard('web')->user()->whitelabels()->first()->id;
            } else {
                return redirect(route('provider.footer.tnb', $request->language))->with('error', trans('User guard is different'));
            }

            $this->languageline->update(
                $this->languageline->firstOrCreate([
                    'locale'         => $request->get('language'),
                    'key'            => 'footer.tnb',
                    'group'          => 'layer_tnb',
                    'whitelabel_id'  => $whiteLabelID])->id,
                ['text'=> $request->get('footer_tnb_editor')]
            );

            $step = null;

            if ($this->auth->guard('web')->user()->hasRole(Flag::EXECUTIVE_ROLE) && !$this->auth->guard('web')->user()->hasRole(Flag::ADMINISTRATOR_ROLE)) {
                $whitelabel = $this->auth->guard('web')->user()->whitelabels()->first();

                if ((int) $whitelabel->state < 6) {
                    $this->whitelabels->update(
                        $this->auth->guard('web')->user()->whitelabels()->first()->id,
                        ['state' => 6]
                    );
                }

                $step = Flag::step()[7];
            }

            $result['success'] = true;
            $result['status'] = 200;

            return redirect(route('provider.footer.tnb', $request->language))->withStep($step)->with('success', trans('tnb.stored'));
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;

            return redirect(route('provider.footer.tnb', $request->language))->with('error', trans('tnb.not_stored'));
        }
    }
}
