<?php

namespace Modules\Whitelabels\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Str;
use Illuminate\Translation\Translator;
use Modules\Attachments\Repositories\Contracts\AttachmentsRepository;
use Modules\Whitelabels\Http\Requests\StoreHostWhitelabelByExecutiveRequest;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

class HostsController extends Controller
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

    public function store(StoreHostWhitelabelByExecutiveRequest $request)
    {
        try {
            $result['whitelabel'] = $this->whitelabels->addHost(
                str_replace('https://', '', $request->get('host')),
                (int) $request->get('whitelebelId')
            );

            $result['message'] = $this->lang->get('messages.deleted', ['attribute' => 'Domain']);
            $result['success'] = true;
            $result['status'] = Flag::STATUS_CODE_SUCCESS;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['status'] = Flag::STATUS_CODE_ERROR;
        }

        return $this->response->json($result, $result['status'], [], JSON_NUMERIC_CHECK);
    }

    public function destroy(string $host)
    {
        try {
            $result['whitelabel'] = $this->whitelabels->deleteHost(
                $host
            );

            $result['message'] = $this->lang->get('messages.updated', ['attribute' => 'Whitelabel']);
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
