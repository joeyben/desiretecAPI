<?php

namespace Modules\Whitelabels\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Str;
use Illuminate\Translation\Translator;
use Modules\Attachments\Repositories\Contracts\AttachmentsRepository;
use Modules\Whitelabels\Http\Requests\SaveWhitelabelByExecutiveRequest;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

class WhitelabelsController extends Controller
{
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;
    /**
     * @var \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository
     */
    private $whitelabels;
    /**
     * @var \Illuminate\Support\Str
     */
    private $str;
    /**
     * @var \Modules\Attachments\Repositories\Contracts\AttachmentsRepository
     */
    private $attachments;
    /**
     * @var \Illuminate\Contracts\Console\Kernel
     */
    private $artisan;
    /**
     * @var \Illuminate\Translation\Translator
     */
    private $lang;
    /**
     * @var \Illuminate\Routing\ResponseFactory
     */
    private $response;

    public function __construct(AuthManager $auth, WhitelabelsRepository $whitelabels, Str $str, AttachmentsRepository $attachments, Kernel $artisan, Translator $lang, ResponseFactory $response)
    {
        $this->auth = $auth;
        $this->whitelabels = $whitelabels;
        $this->str = $str;
        $this->attachments = $attachments;
        $this->artisan = $artisan;
        $this->lang = $lang;
        $this->response = $response;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if ($this->auth->guard('web')->user()->hasRole(Flag::ADMINISTRATOR_ROLE)) {
            return redirect()->route('admin.whitelabels');
        }

        $step = Flag::step()[2];

        return view('whitelabels::provider', compact(['step']));
    }

    public function snippet()
    {
        $step = null;

        if ($this->auth->guard('web')->user()->hasRole(Flag::EXECUTIVE_ROLE) && !$this->auth->guard('web')->user()->hasRole(Flag::ADMINISTRATOR_ROLE)) {
            $whitelabel = $this->auth->guard('web')->user()->whitelabels()->first();

            if ((int) $whitelabel->state < 11) {
                $this->whitelabels->update(
                    $this->auth->guard('web')->user()->whitelabels()->first()->id,
                    ['state' => 11]
                );
            }

            $step = Flag::step()[12];
        }

        return view('whitelabels::snippet', compact(['step', 'whitelabel']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function howItWorks()
    {
        return view('whitelabels::how_it_works');
    }

    /**
     * Show the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return view('whitelabels::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit()
    {
        return view('whitelabels::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function destroy()
    {
    }

    public function save(SaveWhitelabelByExecutiveRequest $request, int $id)
    {
        try {
            $result['whitelabel'] = $this->whitelabels->update(
                $id,
                $request->only('display_name', 'color', 'email')
            );

            $subDomain = str_slug(str_replace('.', '', $request->get('sub_domain')));
            $domain = Flag::HTTPS . $subDomain . $request->get('main_domain');

            if ($result['whitelabel']->domain !== $this->str->lower($domain)) {
                if ($this->isOldWhitelabel()) {
                    $this->whitelabels->updateRoute($id, $result['whitelabel']->name, $subDomain);
                } else {
                    $this->whitelabels->updateHost($id, $result['whitelabel']->domain, $domain);
                }

                ini_set('max_execution_time', 300);
                $result['whitelabel'] = $this->whitelabels->update($id, ['name' => $subDomain, 'domain' => $domain]);

                if ($this->isOldWhitelabel()) {
                    $this->artisan->call('whitelabel:make-route', ['domain' => $subDomain, 'module' => $result['whitelabel']->name]);
                }
            }

            $result['message'] = $this->lang->get('messages.created', ['attribute' => 'Whitelabel']);
            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }
}
