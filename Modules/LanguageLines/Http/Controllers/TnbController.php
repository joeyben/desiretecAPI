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
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Translation\Translator;
use Modules\LanguageLines\Http\Requests\FooterTnbStoreRequest;
use Modules\LanguageLines\Repositories\Contracts\LanguageLinesRepository;
use Modules\Languages\Repositories\Contracts\LanguagesRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;
use Modules\LanguageLines\Entities\LanguageLines;

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
            if ($this->auth->guard('web')->user()->whitelabels()->first() === null){
                abort(403, trans('errors.user.nowhitelabel'));
            }

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

            if ($this->auth->guard('web')->user()->hasRole(Flag::ADMINISTRATOR_ROLE)) {
                $whiteLabelID = getCurrentWhiteLabelField('id');
                $whiteLabelName = getCurrentWhiteLabelField('display_name');
                $domain = getCurrentWhiteLabelField('domain');
            } else if($this->auth->guard('web')->user()->hasRole(Flag::EXECUTIVE_ROLE)){
                $whiteLabelID = $this->auth->guard('web')->user()->whitelabels()->first()->id;
                $whiteLabelName = $this->auth->guard('web')->user()->whitelabels()->first()->display_name;
                $domain = $this->auth->guard('web')->user()->whitelabels()->first()->domain;
            } else {
                return redirect(route('provider.footer.tnb', $lang))->with('error', trans('User guard is different'));
            }

             if (!$this->isOldWhitelabel()) {
                 // new Logic
                 if (!$this->languageline->withCriteria([
                     new Where('locale', $lang),
                     new Where('key', 'footer.tnb'),
                     new Where('group', 'layer'),
                     new Where('whitelabel_id', $whiteLabelID),
                 ])->get()->count()) {
                     $tnb = str_replace('$KUNDE', $whiteLabelName, trans('tnb.template'));
                     $tnb = str_replace('$URL-REISEWUNSCHPORTAL', $domain, $tnb);

                     $result['data']['text'] = $this->languageline->firstOrCreate([
                         'locale' => $lang,
                         'key'    => 'footer.tnb',
                         'group'  => 'layer',
                         'text'   => $tnb,
                         'whitelabel_id'   => $whiteLabelID,
                     ])->text;
                 } else {
                     $result['data']['text'] = $this->languageline->withCriteria([
                         new Where('locale', $lang),
                         new Where('key', 'footer.tnb'),
                         new Where('group', 'layer'),
                         new Where('whitelabel_id', $whiteLabelID),
                     ])->first()->text;
                 }
             } else {
                 // old Logic
                 if (!$this->languageline->withCriteria([
                     new Where('locale', $lang),
                     new Where('key', 'footer.tnb'),
                     new Where('group', 'layer'),
                 ])->get()->count()) {
                     if ($this->auth->guard('web')->user()->hasRole('Admin')) {
                         $whiteLabelName = getCurrentWhiteLabelField('display_name');
                         $domain = getCurrentWhiteLabelField('domain');
                     } else if($this->auth->guard('web')->user()->hasRole(Flag::EXECUTIVE_ROLE)){
                         $whiteLabelName = $this->auth->guard('web')->user()->whitelabels()->first()->display_name;
                         $domain = $this->auth->guard('web')->user()->whitelabels()->first()->domain;
                     } else {
                         return redirect(route('provider.footer.tnb', $lang))->with('error', trans('User guard is different'));
                     }

                     $tnb = str_replace('$KUNDE', $whiteLabelName, trans('tnb.template'));
                     $tnb = str_replace('$URL-REISEWUNSCHPORTAL', $domain, $tnb);

                     $result['data']['text'] = $this->languageline->firstOrCreate([
                         'locale' => $lang,
                         'key'    => 'footer.tnb',
                         'group'  => 'layer',
                         'text'   => $tnb
                     ])->text;
                 } else {
                     $result['data']['text'] = $this->languageline->withCriteria([
                         new Where('locale', $lang),
                         new Where('key', 'footer.tnb'),
                         new Where('group', 'layer'),
                     ])->first()->text;
                 }
             }

            $result['data']['language'] = $lang;
            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return view('languagelines::footer-tnb', compact(['step', 'result']));
    }

    /**
     * Edit already existing Teilnahmebedingungen or Create new Teilnahmebedingungen.
     *
     * @return Response
     */
    public function tnbStore(FooterTnbStoreRequest $request)
    {
        try {
            if (!$this->isOldWhitelabel()) {
                if ($this->auth->guard('web')->user()->hasRole('Admin')) {
                    $whiteLabelID = getCurrentWhiteLabelField('id');
                } else if($this->auth->guard('web')->user()->hasRole('Executive')){
                    $whiteLabelID = $this->auth->guard('web')->user()->whitelabels()->first()->id;
                } else {
                    return redirect(route('provider.footer.tnb', $request->language))->with('error', trans('User guard is different'));
                }

                $languageline = $this->languageline->update(
                    $this->languageline->firstOrCreate([
                        'locale' => $request->get('language'),
                        'key'    => 'footer.tnb',
                        'group'  => 'layer',
                        'whitelabel_id'  => $whiteLabelID])->id,
                    ['text'=> $request->get('footer_tnb_editor')]
                );
            } else {
                $languageline = $this->languageline->update(
                    $this->languageline->firstOrCreate([
                        'locale' => $request->get('language'),
                        'key'    => 'footer.tnb',
                        'group'  => 'layer'])->id,
                    ['text'=> $request->get('footer_tnb_editor')]
                );
            }

            $result['success'] = true;
            $result['status'] = 200;

            return redirect(route('provider.footer.tnb', $request->language))->with('success', trans('tnb.stored'));
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;

            return redirect(route('provider.footer.tnb', $request->language))->with('error', trans('tnb.not_stored'));
        }
    }
}
