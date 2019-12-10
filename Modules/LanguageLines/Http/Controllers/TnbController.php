<?php

namespace Modules\LanguageLines\Http\Controllers;

use App\Models\Access\Role\Role;
use App\Repositories\Criteria\Where;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\DatabaseManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Translation\Translator;
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
     *
     * @param LanguageLinesRepository                                           $languageline
     * @param \Illuminate\Routing\ResponseFactory                               $response
     * @param \Illuminate\Auth\AuthManager                                      $auth
     * @param \Illuminate\Translation\Translator                                $lang
     * @param \Illuminate\Support\Carbon                                        $carbon
     * @param \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository $whitelabels
     * @param \Illuminate\Database\DatabaseManager                              $database
     * @param \Illuminate\Notifications\ChannelManager                          $notification
     * @param \App\Models\Access\Role\Role                                      $role
     * @param \Modules\Languages\Repositories\Contracts\LanguagesRepository     $languages
     * @param \Illuminate\Contracts\Console\Kernel                              $artisan
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

    /**
     * Fetch already existing Footer Teilnahmebedingungen or Create new Teilnahmebedingungen.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function tnb(string $lang)
    {
        try {
            if (!$this->languageline->withCriteria([
                new Where('locale', $lang),
                new Where('key', 'footer.tnb'),
                new Where('group', 'layer'),
            ])->get()->count()) {
                if($this->auth->guard('web')->user()->hasRole('Admin')){
                    $whiteLabelName = getCurrentWhiteLabelField('display_name');
                    $domain = getCurrentWhiteLabelField('domain');
                } else {
                    $whiteLabelName = $this->auth->guard('web')->user()->whitelabels()->first()->display_name;
                    $domain = $this->auth->guard('web')->user()->whitelabels()->first()->domain;
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

            $result['data']['language'] = $lang;
            $result['success'] = true;
            $result['status'] = 200;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = 500;
        }

        return view('languagelines::footer-tnb', compact('result'));
    }

    /**
     * Edit already existing Teilnahmebedingungen or Create new Teilnahmebedingungen.
     *
     * @param FooterTnbStoreRequest $request
     *
     * @return Response
     */
    public function tnbStore(FooterTnbStoreRequest $request)
    {
        try {
            $languageline = $this->languageline->update(
                $this->languageline->firstOrCreate([
                'locale' => $request->get('language'),
                'key'    => 'footer.tnb',
                'group'  => 'layer'])->id,
                ['text'=> $request->get('footer_tnb_editor')]
            );

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
